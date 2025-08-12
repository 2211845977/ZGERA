<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddStudentsCourseController extends Controller
{
    public function index()
    {
        return view('teachers.add-students-course.index');
    }
}
