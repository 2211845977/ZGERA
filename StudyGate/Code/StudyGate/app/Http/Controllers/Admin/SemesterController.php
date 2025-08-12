<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Faker\Provider\ar_EG\Company;
use Illuminate\Http\Request;

class SemesterController extends Controller
{

     public function ShowSemester(){
        $semesters = Semester::orderBy('start_date','desc')->get();
        return view ('Admin.Semesters.index',Compact('semesters'));
    }
    public function ShowCreateSemester(){
        return view ('Admin.Semesters.create');
    }
    public function store(Request $request)
{
    $latestSemester = Semester::orderBy('end_date', 'desc')->first();

    if ($latestSemester && $latestSemester->end_date > now()) {
        return redirect()->route('semesters.index')->with('error', 'You cannot start a new semester before the previous one ends.');
    }

    $validated = $request->validate([
        'name' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
    ]);

    Semester::create([
        'name' => $validated['name'],
        'start_date' => $validated['start_date'],
        'end_date' => $validated['end_date'],
        'enrollment_open' => 0,
    ]);

    return redirect()->route('semesters.index')->with('success', 'Semester started successfully.');
}


public function toggleEnrollment($id)
{
    $semester = Semester::findOrFail($id);
    $semester->enrollment_open = !$semester->enrollment_open;
    $semester->save();

    return redirect()->route('semesters.index')->with('success', 'Enrollment status updated.');
}



}
