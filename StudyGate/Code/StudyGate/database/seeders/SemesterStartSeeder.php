<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SemesterStart;
use App\Models\User;
use App\Models\Semester;

class SemesterStartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الحصول على جميع الطلاب والفصل المتاح للتسجيل
        $students = User::where('role', 'student')->get();
        $semester = Semester::where('enrollment_open', true)
                          ->orWhere('is_active', true)
                          ->first();
        
        if ($students->isNotEmpty() && $semester) {
            foreach ($students as $student) {
                // التحقق من أن الطالب غير مسجل في هذا الفصل
                $existingRegistration = SemesterStart::where('student_id', $student->id)
                    ->where('semester_id', $semester->id)
                    ->first();
                    
                if (!$existingRegistration) {
                    SemesterStart::create([
                        'student_id' => $student->id,
                        'semester_id' => $semester->id,
                        'started_at' => now()
                    ]);
                }
            }
        }
    }
}
