<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubjectOffer;
use App\Models\ClassSchedule;
use App\Models\Semester;

class SchedulesController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();
        
        // الحصول على الفصل الحالي النشط
        $currentSemester = Semester::where('is_active', true)->first();

        if (!$currentSemester) {
            return view('teachers.teacher-schedules.index', [
                'currentSemester' => null,
                'schedules' => [],
                'hasSubjects' => false,
                'message' => 'لا يوجد فصل دراسي نشط حالياً'
            ]);
        }

        // جلب المواد المكلف بها المعلم في الفصل الحالي فقط
        $subjectOffers = $teacher->teachingSubjects()
            ->where('semester_id', $currentSemester->id)
            ->with(['subject', 'schedules'])
            ->get();

        if ($subjectOffers->isEmpty()) {
            return view('teachers.teacher-schedules.index', [
                'currentSemester' => $currentSemester,
                'schedules' => [],
                'hasSubjects' => false,
                'message' => 'ليس لديك مواد مكلف بها في الفصل الحالي'
            ]);
        }

        // إنشاء مصفوفة معلومات المواد
        $subjectsInfo = [];
        foreach ($subjectOffers as $offer) {
            $subjectsInfo[$offer->id] = [
                'name' => $offer->subject->name ?? '',
                'code' => $offer->subject->code ?? '',
                'units' => $offer->subject->units ?? 0
            ];
        }

        // جلب جميع الجداول للمواد المكلف بها المعلم
        $subjectOfferIds = $subjectOffers->pluck('id')->toArray();
        $schedules = ClassSchedule::whereIn('subject_offer_id', $subjectOfferIds)
            ->with(['subjectOffer.subject'])
            ->get();

        // بناء مصفوفة الأيام والجلسات ديناميكياً (نفس منطق الطلبة)
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
                    'time' => $this->getSessionTime($sessionKey),
                    'subject' => '',
                    'subject_code' => '',
                    'room' => '',
                    'not_scheduled' => true
                ];
            }
        }

        // ملء الجدول بالمواد المجدولة
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

        // إضافة المواد التي ليس لها أي جدول (تظهر في خانة "لم يحدد بعد")
        $scheduledSubjectOfferIds = $schedules->pluck('subject_offer_id')->unique()->toArray();
        $notScheduledSubjects = array_diff($subjectOfferIds, $scheduledSubjectOfferIds);
        
        

        // إحصائيات الجدول
        $stats = $this->calculateScheduleStats($schedules, $subjectOffers);

        return view('teachers.teacher-schedules.index', [
            'currentSemester' => $currentSemester,
            'schedules' => $scheduleMatrix,
            'hasSubjects' => true,
            'message' => null,
            'stats' => $stats
        ]);
    }

    // دالة مساعدة لإرجاع اسم اليوم بالعربي (نفس الطلبة)
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

    // دالة مساعدة لإرجاع وقت الجلسة
    private function getSessionTime($sessionKey)
    {
        $times = [
            'session1' => '8:00 - 10:00',
            'session2' => '10:00 - 12:00',
            'session3' => '12:00 - 2:00',
            'session4' => '2:00 - 4:00',
            'session5' => '4:00 - 6:00',
        ];
        return $times[$sessionKey] ?? '';
    }

    // دالة لحساب إحصائيات الجدول
    private function calculateScheduleStats($schedules, $subjectOffers)
    {
        $totalHours = $schedules->count() * 2; // كل جلسة ساعتين
        $totalSubjects = $subjectOffers->count();
        $totalStudents = $subjectOffers->sum(fn($offer) => $offer->enrollments->count());
        
        return [
            'total_hours' => $totalHours,
            'total_subjects' => $totalSubjects,
            'total_students' => $totalStudents,
            'scheduled_classes' => $schedules->count(),
            'total_units' => $subjectOffers->sum(fn($offer) => $offer->subject->units ?? 0)
        ];
    }
}
