<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Enrollment;
use App\Models\ClassSchedule;
use App\Models\SemesterStart;

class ClassScheduleController extends Controller
{
    public function ShowClassSchedules()
    {
        $user = Auth::user();
        
        // البحث عن الفصل الذي سجل فيه الطالب
        $registeredSemester = $this->getStudentRegisteredSemester($user);

        if (!$registeredSemester) {
            return view('Student.course-schedule.index', [
                'currentSemester' => null,
                'schedules' => [],
                'notScheduledSubjects' => [],
                'hasEnrollments' => false,
                'message' => 'يجب عليك التسجيل في فصل دراسي أولاً لعرض الجدول'
            ]);
        }

        $enrollments = Enrollment::where('student_id', $user->id)
            ->whereHas('subjectOffer', function($query) use ($registeredSemester) {
                $query->where('semester_id', $registeredSemester->id);
            })
            ->with(['subjectOffer.subject'])
            ->get();

        if ($enrollments->isEmpty()) {
            return view('Student.course-schedule.index', [
                'currentSemester' => $registeredSemester,
                'schedules' => [],
                'notScheduledSubjects' => [],
                'hasEnrollments' => false,
                'message' => 'لم يتم تسجيل أي مواد في الفصل الحالي'
            ]);
        }

        $enrolledSubjectOfferIds = $enrollments->pluck('subject_offer_id')->toArray();
        $subjectsInfo = [];
        foreach ($enrollments as $enrollment) {
            $subjectsInfo[$enrollment->subject_offer_id] = [
                'name' => $enrollment->subjectOffer->subject->name ?? '',
                'code' => $enrollment->subjectOffer->subject->code ?? ''
            ];
        }

        $schedules = ClassSchedule::whereIn('subject_offer_id', $enrolledSubjectOfferIds)
            ->with(['subjectOffer.subject'])
            ->get();

        // بناء مصفوفة الأيام والجلسات ديناميكياً
        $daysOrder = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday'];
        $sessionsOrder = ['session1','session2','session3','session4','session5'];

        // بناء مصفوفة الجدول بالشكل المطلوب للـ view
        $scheduleMatrix = [];
        foreach ($daysOrder as $dayKey) {
            $scheduleMatrix[$dayKey] = [
                'day_name' => $this->getDayNameArabic($dayKey),
                'sessions' => []
            ];
            foreach ($sessionsOrder as $sessionKey) {
                $scheduleMatrix[$dayKey]['sessions'][$sessionKey] = [
                    'time' => '',
                    'subject' => '',
                    'subject_code' => '',
                    'room' => '',
                    'not_scheduled' => true
                ];
            }
        }

        // ملء الجدول بالمواد المسجلة
        foreach ($schedules as $schedule) {
            $dayKey = $schedule->day_of_week;
            $sessionKey = $schedule->session;
            if (isset($scheduleMatrix[$dayKey]['sessions'][$sessionKey])) {
                $scheduleMatrix[$dayKey]['sessions'][$sessionKey]['subject'] = $schedule->subjectOffer->subject->name ?? '';
                $scheduleMatrix[$dayKey]['sessions'][$sessionKey]['subject_code'] = $schedule->subjectOffer->subject->code ?? '';
                $scheduleMatrix[$dayKey]['sessions'][$sessionKey]['room'] = $schedule->room ?? '';
                $scheduleMatrix[$dayKey]['sessions'][$sessionKey]['not_scheduled'] = false;
            }
        }

        // جمع المواد التي ليس لها أي جدول (لعرضها في قسم منفصل)
        $scheduledSubjectOfferIds = $schedules->pluck('subject_offer_id')->unique()->toArray();
        $notScheduledSubjectOfferIds = array_diff($enrolledSubjectOfferIds, $scheduledSubjectOfferIds);
        $notScheduledSubjects = [];
        
        if (!empty($notScheduledSubjectOfferIds)) {
            foreach ($notScheduledSubjectOfferIds as $subjectOfferId) {
                $notScheduledSubjects[] = [
                    'name' => $subjectsInfo[$subjectOfferId]['name'],
                    'code' => $subjectsInfo[$subjectOfferId]['code']
                ];
            }
        }

        return view('Student.course-schedule.index', [
            'currentSemester' => $registeredSemester,
            'schedules' => $scheduleMatrix,
            'notScheduledSubjects' => $notScheduledSubjects,
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

    // دالة مساعدة لإرجاع اسم اليوم بالعربي
    private function getDayNameArabic($dayKey)
    {
        $days = [
            'Saturday' => 'السبت',
            'Sunday' => 'الأحد',
            'Monday' => 'الاثنين',
            'Tuesday' => 'الثلاثاء',
            'Wednesday' => 'الأربعاء',
            'Thursday' => 'الخميس',
        ];
        return $days[$dayKey] ?? $dayKey;
    }
} 