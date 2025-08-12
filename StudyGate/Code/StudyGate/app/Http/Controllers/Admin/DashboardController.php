<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\User;
use App\Models\ExamSchedule;
use App\Models\Semester;
use App\Models\Enrollment;
use App\Models\SubjectOffer;
use Illuminate\Http\Request;  

class DashboardController extends Controller
{

    public function ShowDashboard()
    {



        $studentsCount = User::where('role', 'student')->count();
        $subjectsCount = Subject::count();
        $teachersCount = User::where('role', 'teacher')->count();
        $semestersCount = Semester::count();

        $latestExams = ExamSchedule::with('subjectOffer.subject')
        ->orderBy('exam_date', 'desc')
        ->take(5)
        ->get();

        $studentsPerSemester = Enrollment::with('subjectOffer.semester')
        ->get()
        ->groupBy(function ($enrollment) {
            return optional($enrollment->subjectOffer->semester)->name;
        })
        ->map(function ($group) {
            return $group->pluck('student_id')->unique()->count();
        });

        $subjectsPerSemester = SubjectOffer::with('semester')
        ->get()
        ->groupBy(function ($offer) {
            return optional($offer->semester)->name;
        })
        ->map(function ($group) {
            return $group->count();
        });

        return view('Admin.Dashboard.index', compact(
        'studentsCount',
        'subjectsCount',
        'teachersCount',
        'semestersCount',
        'latestExams',
        'studentsPerSemester',
        'subjectsPerSemester'
        
    ));

    }
}