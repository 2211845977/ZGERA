<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\SemesterStart;
use Illuminate\Http\Request;

class SemesterRegistrationController extends Controller
{
    public function registerForSemester($semesterId)
    {
        $user = Auth::user();
        
        // التحقق من وجود الفصل الدراسي
        $semester = Semester::findOrFail($semesterId);
        
        // التحقق من أن الفصل متاح للتسجيل
        if (!$semester->enrollment_open) {
            return response()->json([
                'success' => false,
                'message' => 'هذا الفصل غير متاح للتسجيل حالياً'
            ]);
        }
        
        // التحقق من أن الطالب لم يسجل في هذا الفصل من قبل
        $existingRegistration = SemesterStart::where('student_id', $user->id)
            ->where('semester_id', $semesterId)
            ->first();
            
        if ($existingRegistration) {
            return response()->json([
                'success' => false,
                'message' => 'لقد سجلت في هذا الفصل مسبقاً'
            ]);
        }
        
        // تسجيل الطالب في الفصل الجديد
        SemesterStart::create([
            'student_id' => $user->id,
            'semester_id' => $semesterId,
            'started_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'تم تسجيلك في الفصل بنجاح',
            'semester' => [
                'id' => $semester->id,
                'name' => $semester->name,
                'start_date' => $semester->start_date->format('Y-m-d'),
                'end_date' => $semester->end_date->format('Y-m-d')
            ]
        ]);
    }
} 