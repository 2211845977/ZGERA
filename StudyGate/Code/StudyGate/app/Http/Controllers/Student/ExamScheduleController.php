<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Enrollment;
use App\Models\ExamSchedule;
use App\Models\SemesterStart;

class ExamScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // البحث عن الفصل الذي سجل فيه الطالب
        $registeredSemester = $this->getStudentRegisteredSemester($user);

        if (!$registeredSemester) {
            return view('Student.exam-schedule.index', [
                'currentSemester' => null,
                'examSchedules' => [],
                'hasEnrollments' => false,
                'message' => 'يجب عليك التسجيل في فصل دراسي أولاً لعرض جدول الامتحانات'
            ]);
        }

        // جلب المواد المسجلة للطالب في الفصل المسجل فيه
        $enrollments = Enrollment::where('student_id', $user->id)
            ->whereHas('subjectOffer', function($query) use ($registeredSemester) {
                $query->where('semester_id', $registeredSemester->id);
            })
            ->with(['subjectOffer.subject'])
            ->get();

        if ($enrollments->isEmpty()) {
            return view('Student.exam-schedule.index', [
                'currentSemester' => $registeredSemester,
                'examSchedules' => [],
                'hasEnrollments' => false,
                'message' => 'لم يتم تسجيل أي مواد في الفصل الحالي'
            ]);
        }

        // جلب جداول الامتحانات للمواد المسجلة
        $enrolledSubjectOfferIds = $enrollments->pluck('subject_offer_id')->toArray();
        
        $examSchedules = ExamSchedule::whereIn('subject_offer_id', $enrolledSubjectOfferIds)
            ->with(['subjectOffer.subject'])
            ->orderBy('exam_date')
            ->orderBy('session')
            ->get();

        // بناء معلومات المواد
        $subjectsInfo = [];
        foreach ($enrollments as $enrollment) {
            $subjectsInfo[$enrollment->subject_offer_id] = [
                'name' => $enrollment->subjectOffer->subject->name ?? '',
                'code' => $enrollment->subjectOffer->subject->code ?? ''
            ];
        }

        return view('Student.exam-schedule.index', [
            'currentSemester' => $registeredSemester,
            'examSchedules' => $examSchedules,
            'subjectsInfo' => $subjectsInfo,
            'hasEnrollments' => true,
            'message' => null
        ]);
    }

    /**
     * الحصول على الفصل الذي سجل فيه الطالب
     */
    private function getStudentRegisteredSemester($user)
    {
        // البحث عن الفصل الذي سجل فيه الطالب (من جدول SemesterStart)
        $semesterStart = SemesterStart::where('student_id', $user->id)
            ->whereHas('semester', function($query) {
                // البحث عن الفصل النشط فقط
                $query->where('is_active', true);
            })
            ->with('semester')
            ->orderBy('created_at', 'desc')
            ->first();

        return $semesterStart ? $semesterStart->semester : null;
    }
} 