<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubjectOffer;
use App\Models\Subject;
use App\Models\User;
use App\Models\Semester;

class Fall2025SubjectOffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // جلب فصل خريف 2025
        $fall2025Semester = Semester::where('name', 'فصل الخريف 2025')
                                  ->where('enrollment_open', true)
                                  ->first();
        
        if (!$fall2025Semester) {
            $this->command->error('لا يوجد فصل خريف 2025 متاح للتسجيل');
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
        
        // حذف أي عروض مواد موجودة مسبقاً لفصل خريف 2025
        SubjectOffer::where('semester_id', $fall2025Semester->id)->delete();
        
        // إضافة جميع المواد لفصل خريف 2025
        $addedCount = 0;
        foreach ($subjects as $subject) {
            // اختيار مدرس عشوائي
            $randomTeacher = $teachers->random();
            
            SubjectOffer::create([
                'subject_id' => $subject->id,
                'teacher_id' => $randomTeacher->id,
                'semester_id' => $fall2025Semester->id,
            ]);
            
            $addedCount++;
        }
        
        $this->command->info("تم إضافة {$addedCount} مادة معروضة لفصل {$fall2025Semester->name}");
        
        // عرض إحصائيات
        $this->command->info("إحصائيات:");
        $this->command->info("- عدد المواد المضافة: " . $addedCount);
        $this->command->info("- عدد المدرسين: " . $teachers->count());
        $this->command->info("- الفصل: " . $fall2025Semester->name);
        $this->command->info("- تاريخ البداية: " . $fall2025Semester->start_date);
        $this->command->info("- تاريخ النهاية: " . $fall2025Semester->end_date);
    }
} 