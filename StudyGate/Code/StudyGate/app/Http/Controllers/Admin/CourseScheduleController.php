<?php

namespace App\Http\Controllers\Admin;
use App\Models\ClassSchedule;
use App\Http\Controllers\Controller;
use App\Models\SubjectOffer;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Semester;

class CourseScheduleController extends Controller
{
    public function index()
    {
        $schedules = ClassSchedule::with('subjectOffer')->get();
        return view('admin.course-schedule.index', compact('schedules'));
    }

    public function create()
    {
        $currentSemester = Semester::where('is_active', 1)->first();
        $subjectOffers = SubjectOffer::with(['subject', 'teacher'])->get()->where('semester_id', $currentSemester->id);
        return view('admin.course-schedule.create', compact('subjectOffers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_offer_id' => 'required|exists:subject_offers,id',
            'day_of_week' => 'required|string',
            'session' => 'required|string',
            'room' => 'required|string',
        ]);

        // إنشاء المحاضرة
        $schedule = ClassSchedule::create($request->all());

        // جلب معلومات المادة والمعلم
        $subjectOffer = SubjectOffer::with(['subject', 'teacher'])->find($request->subject_offer_id);

        // إنشاء إشعار جديد
        Notification::create([
            'type' => 'lecture',
            'title' => 'تمت إضافة محاضرة جديدة',
            'body' => 'تمت إضافة محاضرة ' . ($subjectOffer->subject->name ?? 'غير معروف') .
                ' يوم ' . $request->day_of_week .
                ' في الفترة ' . $request->session .
                ' في القاعة ' . $request->room .
                ' بواسطة الإدارة.',
            'user_id' => null, // إشعار عام لجميع المعلمين
            'is_read' => false,
        ]);

        return redirect()->route('admin.course-schedule.index')->with('success', 'تمت إضافة المحاضرة بنجاح.');
    }


    public function show($id)
    {
        return view('admin.course-schedule.show', compact('id'));
    }

    public function edit($id)
    {
        $schedule = ClassSchedule::findOrFail($id);
        $subjectOffers = SubjectOffer::with(['subject', 'teacher'])->get(); // لتعبئة الاختيارات
        return view('admin.course-schedule.edit', compact('schedule', 'subjectOffers'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'subject_offer_id' => 'required|exists:subject_offers,id',
            'day_of_week' => 'required|string',
            'session' => 'required|string',
            'room' => 'required|string',
        ]);

        $schedule = ClassSchedule::findOrFail($id);
        $schedule->update($request->all());

        return redirect()->route('admin.course-schedule.index')->with('success', 'تم تحديث المحاضرة بنجاح.');
    }


    public function destroy($id)
    {
        $schedule = ClassSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.course-schedule.index')->with('success', 'تم حذف المحاضرة بنجاح.');
    }


    public function showMatrix()
    {
        $activeSemester = Semester::where('is_active', 1)->first();

        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Saturday'];
        $sessions = ['session1', 'session2', 'session3', 'session4'];

        $schedules = ClassSchedule::with('subjectOffer.subject')->get();

        $formatted = [];

        foreach ($days as $day) {
            foreach ($sessions as $session) {
                $formatted[$day][$session] = '';
            }
        }

        foreach ($schedules as $item) {
            $subjectName = $item->subjectOffer->subject->name ?? '---';
            $formatted[$item->day_of_week][$item->session] = $subjectName;
        }
        return view('admin.course-schedule.show-matrix', compact('formatted', 'activeSemester'));

    }

}
