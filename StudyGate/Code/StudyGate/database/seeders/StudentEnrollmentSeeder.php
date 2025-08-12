<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\SubjectOffer;
use App\Models\Semester;

class StudentEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // جلب الفصل الحالي النشط
        $currentSemester = Semester::where('is_active', true)->first();
        
        if (!$currentSemester) {
            $this->command->error('لا يوجد فصل دراسي نشط');
            return;
        }
        
        // جلب الطلاب
        $students = User::where('role', 'student')->get();
        
        if ($students->isEmpty()) {
            $this->command->error('لا يوجد طلاب في النظام');
            return;
        }
        
        // جلب عروض المواد للفصل الحالي
        $subjectOffers = SubjectOffer::where('semester_id', $currentSemester->id)->get();
        
        if ($subjectOffers->isEmpty()) {
            $this->command->error('لا يوجد عروض مواد للفصل الحالي');
            return;
        }
        
        // حذف أي تسجيلات موجودة مسبقاً للفصل الحالي
        Enrollment::whereHas('subjectOffer', function($query) use ($currentSemester) {
            $query->where('semester_id', $currentSemester->id);
        })->delete();
        
        // تسجيل الطلاب في المواد
        $enrollmentCount = 0;
        
        foreach ($students as $student) {
            // تسجيل الطالب في 3-4 مواد عشوائية
            $randomSubjectOffers = $subjectOffers->random(rand(3, 4));
            
            foreach ($randomSubjectOffers as $subjectOffer) {
                Enrollment::create([
                    'student_id' => $student->id,
                    'subject_offer_id' => $subjectOffer->id,
                    'enrolled_at' => now(),
                ]);
                
                $enrollmentCount++;
            }
        }
        
        $this->command->info("تم تسجيل الطلاب في {$enrollmentCount} مادة بنجاح");
    }
}
