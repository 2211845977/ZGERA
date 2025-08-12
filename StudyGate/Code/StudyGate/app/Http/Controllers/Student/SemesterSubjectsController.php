<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Enrollment;
use App\Models\GradeRecord;
use Illuminate\Http\Request;

class SemesterSubjectsController extends Controller
{
    public function getSemesterSubjects($semesterId)
    {
        $user = Auth::user();
        
        // التحقق من وجود الفصل الدراسي
        $semester = Semester::findOrFail($semesterId);
        
        // جلب المواد المسجلة للطالب في هذا الفصل
        $enrollments = Enrollment::where('student_id', $user->id)
            ->whereHas('subjectOffer', function($query) use ($semesterId) {
                $query->where('semester_id', $semesterId);
            })
            ->with(['subjectOffer.subject', 'subjectOffer.teacher', 'gradeRecord'])
            ->get();
        
        // التحقق من أن الطالب مسجل في هذا الفصل
        if ($enrollments->isEmpty()) {
            return response()->json([
                'subjects' => [],
                'average' => null,
                'total_units' => 0,
                'message' => 'لم يتم تسجيل أي مواد في هذا الفصل'
            ]);
        }
        
        $subjects = [];
        $totalGrade = 0;
        $gradedCount = 0;
        $totalUnits = 0;
        
        foreach ($enrollments as $enrollment) {
            $grade = null;
            if ($enrollment->gradeRecord) {
                $grade = $enrollment->gradeRecord->grade;
                $totalGrade += $grade;
                $gradedCount++;
            }
            
            // حساب الوحدات الفعلية من المادة
            $subjectUnits = $enrollment->subjectOffer->subject->units;
            $totalUnits += $subjectUnits;
            
            $subjects[] = [
                'subject_id' => $enrollment->subjectOffer->subject->code ?? $enrollment->subjectOffer->subject->id,
                'subject_name' => $enrollment->subjectOffer->subject->name,
                'teacher_name' => $enrollment->subjectOffer->teacher->name ?? 'غير محدد',
                'grade' => $grade,
                'units' => $subjectUnits
            ];
        }
        
        $average = $gradedCount > 0 ? round($totalGrade / $gradedCount, 2) : null;
        
        return response()->json([
            'subjects' => $subjects,
            'average' => $average,
            'total_units' => $totalUnits,
            'semester_name' => $semester->name
        ]);
    }
} 