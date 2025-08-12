<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Semester;
use Carbon\Carbon;

class UpdateCurrentSemesterDateSeeder extends Seeder
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
        
        // تحديث تاريخ بداية الفصل ليكون قبل 15 يوم من اليوم
        $newStartDate = Carbon::now()->subDays(15);
        
        $this->command->info("الفصل الحالي: " . $currentSemester->name);
        $this->command->info("تاريخ البداية السابق: " . $currentSemester->start_date->format('Y-m-d'));
        
        // تحديث التاريخ
        $oldStartDate = $currentSemester->start_date;
        $currentSemester->start_date = $newStartDate;
        $currentSemester->save();
        
        $this->command->info("تاريخ البداية الجديد: " . $currentSemester->fresh()->start_date->format('Y-m-d'));
        
        // حساب الفترة المتبقية للإسقاط (نستخدم fresh() للحصول على البيانات المحدثة)
        $updatedSemester = $currentSemester->fresh();
        $dropDeadline = $updatedSemester->start_date->copy()->addDays(config('academic.enrollment.drop_deadline_days', 60));
        $daysLeft = Carbon::now()->diffInDays($dropDeadline, false);
        
        $this->command->info("الموعد النهائي للإسقاط: " . $dropDeadline->format('Y-m-d'));
        
        if ($daysLeft > 0) {
            $this->command->info("✅ الوقت المتبقي لإسقاط المواد: " . round($daysLeft) . " يوم");
        } else {
            $this->command->info("❌ انتهى وقت إسقاط المواد منذ " . round(abs($daysLeft)) . " يوم");
        }
    }
} 