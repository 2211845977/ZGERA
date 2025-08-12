<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\ClassSchedule;
use Illuminate\Support\Facades\Auth;

class TeacherProfileController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();
        
        // الحصول على الفصل الحالي النشط
        $currentSemester = Semester::where('is_active', true)->first();
        
        if (!$currentSemester) {
            return view('teachers.profile.index', [
                'teacher' => $teacher,
                'currentSemester' => null,
                'subjectOffers' => collect(),
                'subjectCount' => 0,
                'totalStudents' => 0,
                'lectureCount' => 0,
                'totalUnits' => 0
            ]);
        }
        
        // جلب المواد المكلف بها المعلم في الفصل الحالي فقط
        $subjectOffers = $teacher->teachingSubjects()
            ->where('semester_id', $currentSemester->id)
            ->with(['subject', 'semester', 'enrollments.student', 'schedules'])
            ->get();
        
        // حساب الإحصائيات للفصل الحالي
        $subjectCount = $subjectOffers->count();
        $totalStudents = $subjectOffers->sum(fn($offer) => $offer->enrollments->count());
        
        // حساب عدد المحاضرات للفصل الحالي
        $schedules = ClassSchedule::whereIn('subject_offer_id', $subjectOffers->pluck('id'))
            ->with(['subjectOffer.subject'])
            ->get();
        $lectureCount = $schedules->count();
        
        // حساب إجمالي الوحدات
        $totalUnits = $subjectOffers->sum(function($offer) {
            return $offer->subject->units ?? 0;
        });
        
        return view('teachers.profile.index', compact(
            'teacher',
            'currentSemester',
            'subjectOffers', 
            'subjectCount', 
            'totalStudents', 
            'lectureCount',
            'totalUnits'
        ));
    }
}
