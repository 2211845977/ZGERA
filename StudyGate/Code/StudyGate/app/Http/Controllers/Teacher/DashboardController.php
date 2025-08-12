<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\SubjectOffer;
use App\Models\ClassSchedule;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();
        
        // الحصول على الفصل الحالي النشط
        $currentSemester = Semester::where('is_active', true)->first();
        
        if (!$currentSemester) {
            return view('teachers.dashboard.dashboard', [
                'currentSemester' => null,
                'subjectOffers' => collect(),
                'subjectCount' => 0,
                'totalStudents' => 0,
                'lectureCount' => 0,
                'semesterName' => 'لا يوجد فصل دراسي نشط',
                'schedules' => collect(),
                'subjectStats' => []
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
        
        // إحصائيات تفصيلية لكل مادة
        $subjectStats = $subjectOffers->map(function($offer) {
            return [
                'subject_name' => $offer->subject->name,
                'student_count' => $offer->enrollments->count(),
                'lecture_count' => $offer->schedules->count(),
                'units' => $offer->subject->units ?? 0
            ];
        });
        
        return view('teachers.dashboard.dashboard', compact(
            'currentSemester',
            'subjectOffers', 
            'subjectCount', 
            'totalStudents', 
            'lectureCount',
            'schedules',
            'subjectStats'
        ));
    }
}
