<?php

namespace App\Http\Controllers\Admin;
use App\Models\Semester;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamSchedule;
use App\Models\SubjectOffer;
use App\Models\Notification;

class ExamScheduleController extends Controller
{
    public function index()
    {

        $examschedule = ExamSchedule::all();
        $exams = ExamSchedule::with('subjectOffer.subject')->get();

        // Return the view with the examschedule data
        return view('admin.exam-schedule.index', compact('examschedule', 'exams'));
    }

    public function create()
    {
        $currentSemester = Semester::where('is_active', 1)->first();
        $subject_offers = SubjectOffer::with('subjectInfo')->get()->where('semester_id', $currentSemester->id);;
        // Return the view with the subjects data
        return view('admin.exam-schedule.create', compact('subject_offers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subject_offer_id' => 'required|exists:subject_offers,id',
            'exam_date' => 'required|date',
            'session' => 'required|string|max:50',
            'room' => 'required|string|max:50',
        ]);

        // إنشاء الامتحان
        $exam = ExamSchedule::create($validatedData);

        // جلب معلومات المادة
        $subjectOffer = SubjectOffer::with('subject')->find($request->subject_offer_id);

        // إنشاء إشعار جديد
        Notification::create([
            'type' => 'lecture', // يمكن تغييرها إلى 'exam' إذا أردت نوع منفصل
            'title' => 'تمت إضافة امتحان جديد',
            'body' => 'تمت إضافة امتحان ' . ($subjectOffer->subject->name ?? 'غير معروف') .
                     ' في تاريخ ' . $request->exam_date .
                     ' في الفترة ' . $request->session .
                     ' في القاعة ' . $request->room .
                     ' بواسطة الإدارة.',
            'user_id' => null, // إشعار عام لجميع المعلمين
            'is_read' => false,
        ]);

        return redirect()->route('admin.exam-schedule.index');
    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        $exam = ExamSchedule::findOrFail($id);
        $subject_offers = SubjectOffer::with('subjectInfo')->get();

        return view('admin.exam-schedule.edit', compact('exam', 'subject_offers'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'subject_offer_id' => 'required|exists:subject_offers,id',
            'exam_date' => 'required|date',
            'exam_type' => 'required|in:midterm,final',
            'session' => 'required|string|max:50',
            'room' => 'required|string|max:50',
        ]);


        $exam = ExamSchedule::findOrFail($id);


        $exam->update($validatedData);


        return redirect()->route('admin.exam-schedule.index')->with('success', 'تم تحديث بيانات الامتحان بنجاح');
    }

    public function destroy($id)
    {
        $exam = ExamSchedule::findOrFail($id);
        $exam->delete();
        return redirect()->route('admin.exam-schedule.index')
            ->with('success', 'تم حذف الامتحان بنجاح');
    }
    public function showMatrix()
    {
        $activeSemester = Semester::where('is_active', 1)->first();
        // نجيب كل الامتحانات مرتبة حسب التاريخ
        $exams = ExamSchedule::with('subjectOffer.subject')
            ->orderBy('exam_date')
            ->get();

        // نحضّر مصفوفة فاضية
        $matrix = [];

        // نعد الأيام
        $dayCounter = 1;

        foreach ($exams as $exam) {
            $date = $exam->exam_date;

            // لو اليوم مش موجود في المصفوفة، نجهز له صف
            if (!isset($matrix[$date])) {
                $matrix[$date] = [
                    'day_number' => $dayCounter++,
                    'day_name' => date('l', strtotime($date)), // اسم اليوم بالإنجليزي
                    'session1' => '',
                    'session2' => '',
                    'session3' => '',
                    'session4' => '',
                ];
            }

            // نجيب اسم المادة
            $subject = $exam->subjectOffer->subject->name ?? 'غير معروف';

            // نحطها في الفترة المناسبة
            $matrix[$date][$exam->session] = $subject;
        }

        return view('admin.exam-schedule.show-matrix', [
            'matrix' => $matrix,
            'activeSemester' => $activeSemester,
        ]);

    }
}
