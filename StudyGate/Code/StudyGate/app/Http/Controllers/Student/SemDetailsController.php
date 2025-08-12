<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Enrollment;
use App\Models\SubjectOffer;
use App\Models\GradeRecord;
use App\Models\SemesterStart;

class SemDetailsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // أولاً: البحث عن الفصل الذي سجل فيه الطالب
        $registeredSemester = null;
        $isRegisteredForAvailableSemester = false;
        
        // جلب الفصل الذي سجل فيه الطالب (من جدول SemesterStart)
        $semesterStart = SemesterStart::where('student_id', $user->id)
            ->whereHas('semester', function($query) {
                // البحث عن الفصل النشط فقط
                $query->where('is_active', true);
            })
            ->with('semester')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($semesterStart) {
            $registeredSemester = $semesterStart->semester;
            $isRegisteredForAvailableSemester = true;
        }

        // إذا لم يكن مسجلاً، البحث عن الفصل المتاح للتسجيل
        $availableSemester = null;
        if (!$registeredSemester) {
            $availableSemester = Semester::where('enrollment_open', true)->first();
        } else {
            // إذا كان مسجلاً، فالفصل المتاح هو نفس الفصل المسجل فيه
            $availableSemester = $registeredSemester;
        }
        
        // جلب الفصل الحالي النشط (للإحصائيات فقط)
        $currentSemester = Semester::where('is_active', true)->first();
        
        // جلب عدد الوحدات المسجلة للطالب في الفصل الحالي أو المسجل فيه
        $currentUnits = 0;
        $semesterToCheck = $registeredSemester ?: $currentSemester;
        if ($semesterToCheck) {
            $currentUnits = Enrollment::where('student_id', $user->id)
                ->whereHas('subjectOffer', function($query) use ($semesterToCheck) {
                    $query->where('semester_id', $semesterToCheck->id);
                })->count();
        }
        
        // جلب الفصول السابقة التي سجل فيها الطالب فقط
        $previousSemesters = Semester::where('is_active', false)
            ->where('end_date', '<', now())
            ->whereHas('subjectOffers.enrollments', function($query) use ($user) {
                $query->where('student_id', $user->id);
            })
            ->orderBy('end_date', 'desc')
            ->get()
            ->map(function($semester) use ($user) {
                $enrollments = Enrollment::where('student_id', $user->id)
                    ->whereHas('subjectOffer', function($query) use ($semester) {
                        $query->where('semester_id', $semester->id);
                    })
                    ->with(['subjectOffer.subject'])
                    ->get();
                
                $totalUnits = 0;
                $totalGrade = 0;
                $gradedCount = 0;
                
                foreach ($enrollments as $enrollment) {
                    // حساب الوحدات الفعلية من المادة
                    $totalUnits += $enrollment->subjectOffer->subject->units;
                    
                    $gradeRecord = GradeRecord::where('enrollment_id', $enrollment->id)->first();
                    if ($gradeRecord) {
                        $totalGrade += $gradeRecord->grade;
                        $gradedCount++;
                    }
                }
                
                $average = $gradedCount > 0 ? round($totalGrade / $gradedCount, 2) : 0;
                
                return [
                    'semester' => $semester,
                    'units' => $totalUnits,
                    'average' => $average
                ];
            })
            ->filter(function($semesterData) {
                // إزالة الفصول التي لا تحتوي على مواد مسجلة
                return $semesterData['units'] > 0;
            });
        
        // تحويل Collection إلى Array وإزالة التكرار
        $previousSemesters = $previousSemesters->unique('semester.id')->values();
        
        return view('Student.semDetails.index', compact(
            'user', 
            'currentSemester', 
            'availableSemester', 
            'isRegisteredForAvailableSemester',
            'currentUnits',
            'previousSemesters'
        ));
    }
} 