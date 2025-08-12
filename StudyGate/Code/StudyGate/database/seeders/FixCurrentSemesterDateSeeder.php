<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Semester;

class FixCurrentSemesterDateSeeder extends Seeder
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
        
        // تحديد تاريخ ماضي صحيح (قبل شهر من اليوم)
        $newStartDate = now()->subMonth();
        
        $this->command->info("إصلاح تاريخ الفصل: " . $currentSemester->name);
        $this->command->info("التاريخ السابق: " . $currentSemester->start_date);
        
        // تحديث التاريخ مباشرة في قاعدة البيانات
        Semester::where('id', $currentSemester->id)
            ->update(['start_date' => $newStartDate]);
        
        // جلب التاريخ المحدث
        $updatedSemester = Semester::find($currentSemester->id);
        
        $this->command->info("التاريخ الجديد: " . $updatedSemester->start_date);
        
        // حساب الوقت المتبقي للإسقاط
        $dropDeadlineDays = config('academic.enrollment.drop_deadline_days', 60);
        $dropDeadline = $updatedSemester->start_date->addDays($dropDeadlineDays);
        
        $this->command->info("الموعد النهائي للإسقاط: " . $dropDeadline->format('Y-m-d'));
        
        $today = now();
        if ($today <= $dropDeadline) {
            $daysLeft = $today->diffInDays($dropDeadline);
            $this->command->info("✅ الوقت المتبقي لإسقاط المواد: " . $daysLeft . " يوم");
        } else {
            $daysPassed = $dropDeadline->diffInDays($today);
            $this->command->info("❌ انتهى وقت إسقاط المواد منذ " . $daysPassed . " يوم");
        }
    }
} 