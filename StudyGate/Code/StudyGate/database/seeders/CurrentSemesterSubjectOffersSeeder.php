<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubjectOffer;
use App\Models\Subject;
use App\Models\User;
use App\Models\Semester;

class CurrentSemesterSubjectOffersSeeder extends Seeder
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
        
        // جلب المدرسين
        $teachers = User::where('role', 'teacher')->get();
        
        if ($teachers->isEmpty()) {
            $this->command->error('لا يوجد مدرسين في النظام');
            return;
        }
        
        // جلب المواد الموجودة
        $subjects = Subject::all();
        
        if ($subjects->isEmpty()) {
            $this->command->error('لا يوجد مواد في النظام');
            return;
        }
        
        // حذف أي عروض مواد موجودة مسبقاً للفصل الحالي
        SubjectOffer::where('semester_id', $currentSemester->id)->delete();
        
        // إضافة مواد للفصل الحالي
        $addedCount = 0;
        foreach ($subjects as $subject) {
            // اختيار مدرس عشوائي
            $randomTeacher = $teachers->random();
            
            SubjectOffer::create([
                'subject_id' => $subject->id,
                'teacher_id' => $randomTeacher->id,
                'semester_id' => $currentSemester->id,
            ]);
            
            $addedCount++;
        }
        
        $this->command->info("تم إضافة {$addedCount} مادة معروضة للفصل {$currentSemester->name}");
        
        // عرض إحصائيات
        $this->command->info("إحصائيات:");
        $this->command->info("- عدد المواد: " . $subjects->count());
        $this->command->info("- عدد المدرسين: " . $teachers->count());
        $this->command->info("- الفصل: " . $currentSemester->name);
    }
} 