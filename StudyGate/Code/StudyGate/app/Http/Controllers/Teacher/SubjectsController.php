<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SubjectOffer;
use App\Models\Semester;
use Illuminate\Support\Facades\Auth;

class SubjectsController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();
        
        // الحصول على الفصل الحالي النشط
        $currentSemester = Semester::where('is_active', true)->first();
        
        if (!$currentSemester) {
            return view('teachers.subjects-for-teacher.index', [
                'currentSemester' => null,
                'subjectOffers' => collect(),
                'message' => 'لا يوجد فصل دراسي نشط حالياً'
            ]);
        }
        
        // جلب المواد المكلف بها المعلم في الفصل الحالي فقط
        $subjectOffers = $teacher->teachingSubjects()
            ->where('semester_id', $currentSemester->id)
            ->with(['subject', 'semester', 'enrollments.student'])
            ->get();

        return view('teachers.subjects-for-teacher.index', compact(
            'currentSemester',
            'subjectOffers'
        ));
    }

    public function showStudents($subjectOfferId)
    {
        $teacher = Auth::user();
        $currentSemester = Semester::where('is_active', true)->first();
        
        // التأكد من أن المادة تنتمي للمعلم وللفصل الحالي
        $subjectOffer = SubjectOffer::where('id', $subjectOfferId)
            ->where('teacher_id', $teacher->id)
            ->where('semester_id', $currentSemester->id)
            ->with(['enrollments.student', 'subject', 'semester'])
            ->firstOrFail();

        // جلب الطلبة المسجلين في هذه المادة للفصل الحالي فقط
        $students = $subjectOffer->enrollments()
            ->with('student')
            ->get()
            ->pluck('student');

        return view('teachers.subjects-for-teacher.students', compact(
            'subjectOffer', 
            'students',
            'currentSemester'
        ));
    }
}
