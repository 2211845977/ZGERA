<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClassSchedule;
use App\Models\SubjectOffer;
use App\Models\Semester;

class ClassScheduleSeeder extends Seeder
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
        
        // جلب عروض المواد للفصل الحالي
        $subjectOffers = SubjectOffer::where('semester_id', $currentSemester->id)->get();
        
        if ($subjectOffers->isEmpty()) {
            $this->command->error('لا يوجد عروض مواد للفصل الحالي');
            return;
        }
        
        // حذف أي جداول محاضرات موجودة مسبقاً
        ClassSchedule::whereHas('subjectOffer', function($query) use ($currentSemester) {
            $query->where('semester_id', $currentSemester->id);
        })->delete();
        
        // إنشاء جداول محاضرات تجريبية
        $schedules = [
            // السبت
            [
                'subject_offer_id' => $subjectOffers->first()->id,
                'day_of_week' => 'Saturday',
                'session' => 'session2',
                'room' => 'قاعة 101'
            ],
            [
                'subject_offer_id' => $subjectOffers->first()->id,
                'day_of_week' => 'Saturday',
                'session' => 'session4',
                'room' => 'قاعة 101'
            ],
            
            // الأحد
            [
                'subject_offer_id' => $subjectOffers->skip(1)->first()->id,
                'day_of_week' => 'Sunday',
                'session' => 'session1',
                'room' => 'قاعة 102'
            ],
            [
                'subject_offer_id' => $subjectOffers->skip(1)->first()->id,
                'day_of_week' => 'Sunday',
                'session' => 'session3',
                'room' => 'قاعة 102'
            ],
            
            // الاثنين
            [
                'subject_offer_id' => $subjectOffers->skip(2)->first()->id,
                'day_of_week' => 'Monday',
                'session' => 'session2',
                'room' => 'قاعة 103'
            ],
            [
                'subject_offer_id' => $subjectOffers->skip(2)->first()->id,
                'day_of_week' => 'Monday',
                'session' => 'session4',
                'room' => 'قاعة 103'
            ],
            
            // الثلاثاء
            [
                'subject_offer_id' => $subjectOffers->skip(3)->first()->id,
                'day_of_week' => 'Tuesday',
                'session' => 'session1',
                'room' => 'قاعة 104'
            ],
            [
                'subject_offer_id' => $subjectOffers->skip(3)->first()->id,
                'day_of_week' => 'Tuesday',
                'session' => 'session3',
                'room' => 'قاعة 104'
            ],
            
            // الأربعاء
            [
                'subject_offer_id' => $subjectOffers->skip(4)->first()->id,
                'day_of_week' => 'Wednesday',
                'session' => 'session2',
                'room' => 'قاعة 105'
            ],
            [
                'subject_offer_id' => $subjectOffers->skip(4)->first()->id,
                'day_of_week' => 'Wednesday',
                'session' => 'session4',
                'room' => 'قاعة 105'
            ],
            
            // الخميس
            [
                'subject_offer_id' => $subjectOffers->skip(5)->first()->id,
                'day_of_week' => 'Thursday',
                'session' => 'session1',
                'room' => 'قاعة 106'
            ],
            [
                'subject_offer_id' => $subjectOffers->skip(5)->first()->id,
                'day_of_week' => 'Thursday',
                'session' => 'session3',
                'room' => 'قاعة 106'
            ],
        ];
        
        // إنشاء الجداول
        foreach ($schedules as $schedule) {
            // التحقق من وجود عرض المادة
            if (SubjectOffer::find($schedule['subject_offer_id'])) {
                ClassSchedule::create($schedule);
            }
        }
        
        $this->command->info('تم إنشاء جداول المحاضرات بنجاح');
    }
}
