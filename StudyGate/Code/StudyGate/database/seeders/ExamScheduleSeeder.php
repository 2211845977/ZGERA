<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExamSchedule;
use App\Models\SubjectOffer;
use App\Models\Semester;
use Carbon\Carbon;

class ExamScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // جلب الفصل الحالي النشط أو المتاح للتسجيل
        $currentSemester = Semester::where('is_active', true)
            ->orWhere('enrollment_open', true)
            ->first();
        
        if (!$currentSemester) {
            $this->command->error('لا يوجد فصل دراسي نشط أو متاح للتسجيل');
            return;
        }
        
        // جلب عروض المواد للفصل الحالي
        $subjectOffers = SubjectOffer::where('semester_id', $currentSemester->id)->get();
        
        if ($subjectOffers->isEmpty()) {
            $this->command->error('لا يوجد عروض مواد للفصل الحالي');
            return;
        }
        
        // حذف أي جداول امتحانات موجودة مسبقاً
        ExamSchedule::whereHas('subjectOffer', function($query) use ($currentSemester) {
            $query->where('semester_id', $currentSemester->id);
        })->delete();
        
        // إنشاء جداول امتحانات تجريبية
        $examSchedules = [];
        $examDate = Carbon::now()->addWeeks(8); // بعد 8 أسابيع من الآن
        
        foreach ($subjectOffers as $index => $subjectOffer) {
            // امتحان نصفي
            $examSchedules[] = [
                'subject_offer_id' => $subjectOffer->id,
                'exam_type' => 'Midterm',
                'exam_date' => $examDate->copy()->addDays($index),
                'session' => 'session' . (($index % 3) + 1),
                'room' => 'قاعة امتحانات ' . (100 + $index),
            ];
            
            // امتحان نهائي
            $examSchedules[] = [
                'subject_offer_id' => $subjectOffer->id,
                'exam_type' => 'Final',
                'exam_date' => $examDate->copy()->addWeeks(6)->addDays($index),
                'session' => 'session' . (($index % 3) + 1),
                'room' => 'قاعة امتحانات ' . (100 + $index),
            ];
        }
        
        // إنشاء الجداول
        foreach ($examSchedules as $schedule) {
            ExamSchedule::create($schedule);
        }
        
        $this->command->info('تم إنشاء جداول الامتحانات بنجاح');
        $this->command->info('عدد الامتحانات: ' . count($examSchedules));
    }
} 