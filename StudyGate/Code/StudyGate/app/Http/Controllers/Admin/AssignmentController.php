<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\SubjectOffer;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssignmentController extends Controller
{
    /**
     * Display a listing of assigned subjects for a given semester.
     */
    public function index($semesterId)
    {
        $semester = Semester::findOrFail($semesterId);

        // Eager load subjectInfo and teacher relationships
        $offers = SubjectOffer::with(['subjectInfo', 'teacher'])
            ->where('semester_id', $semesterId)
            ->get();

        return view('Admin.Assignments.index', compact('semester', 'offers'));
    }

    /**
     * Show the form for assigning a teacher to a subject in a semester.
     */
    public function create($semesterId)
    {
           $subjects = Subject::all();
            $semester = Semester::findOrFail($semesterId);
            $teachers = User::where('role', 'teacher')->get();

            return view('Admin.Assignments.create', compact('semester', 'subjects', 'teachers'));
    }

    /**
     * Store a new teacher assignment.
     */
    public function store(Request $request, $semesterId)
{
    $validated = $request->validate([
        'subject_id' => 'required|exists:subjects,id',
        'teacher_id' => 'required|exists:users,id',
    ]);

    // إنشاء التخصيص
    $subjectOffer = SubjectOffer::create([
        'subject_id'  => $validated['subject_id'],
        'teacher_id'  => $validated['teacher_id'],
        'semester_id' => $semesterId,
    ]);

    // جلب معلومات المادة والمعلم
    $subject = Subject::find($validated['subject_id']);
    $teacher = User::find($validated['teacher_id']);
    $semester = Semester::find($semesterId);

    // إنشاء إشعار جديد
    Notification::create([
        'type' => 'lecture',
        'title' => 'تم تخصيص معلم لمادة',
        'body' => 'تم تخصيص المعلم ' . ($teacher->name ?? 'غير معروف') .
                 ' لمادة ' . ($subject->name ?? 'غير معروف') .
                 ' في الفصل الدراسي: ' . ($semester->name ?? 'غير معروف') .
                 ' بواسطة الإدارة.',
        'user_id' => null, // إشعار عام لجميع المعلمين
        'is_read' => false,
    ]);

    return redirect()
        ->route('assignments.index', $semesterId)
        ->with('success', 'تم تخصيص الدكتور بنجاح للمادة.');
}
    /**
     * Update an existing teacher assignment.
     */
    public function update(Request $request, $offer_id)
    {
        $request->validate([
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $offer = SubjectOffer::findOrFail($offer_id);
        $offer->teacher_id = $request->teacher_id;
        $offer->save();

       return redirect()->route('assignments.index', ['semester' => $offer->semester_id])
    ->with('success', 'تم تحديث التخصيص بنجاح');

    }

    public function edit($id){
        $subjectOffer= SubjectOffer::with('subjectInfo','teacher','semester')->findOrFail($id);
         $teachers = User::where('role', 'teacher')->get();

        return view('Admin.Assignments.edit', compact('subjectOffer', 'teachers'));


    }

public function destroy($id)
{
    $subjectOffer = SubjectOffer::findOrFail($id);
    $subjectOffer->delete();

    return redirect()->route('assignments.index', ['semester' => $subjectOffer->semester_id])
    ->with('success', 'Assignment deleted successfully.');

}
}
