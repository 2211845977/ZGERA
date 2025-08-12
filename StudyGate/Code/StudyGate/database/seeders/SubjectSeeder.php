<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء مواد دراسية تجريبية
        
        // مواد الفصل الأول
        Subject::create([
            'name' => 'مقدمة في البرمجة',
            'semester' => 'الأول',
            'prerequisite_subject_id' => null,
            'units' => 4,
        ]);

        Subject::create([
            'name' => 'الرياضيات الأساسية',
            'semester' => 'الأول',
            'prerequisite_subject_id' => null,
            'units' => 3,
        ]);

        Subject::create([
            'name' => 'اللغة الإنجليزية',
            'semester' => 'الأول',
            'prerequisite_subject_id' => null,
            'units' => 2,
        ]);

        // مواد الفصل الثاني
        Subject::create([
            'name' => 'برمجة متقدمة',
            'semester' => 'الثاني',
            'prerequisite_subject_id' => 1, // مقدمة في البرمجة
            'units' => 4,
        ]);

        Subject::create([
            'name' => 'هياكل البيانات',
            'semester' => 'الثاني',
            'prerequisite_subject_id' => 1, // مقدمة في البرمجة
            'units' => 3,
        ]);

        Subject::create([
            'name' => 'الإحصاء والاحتمالات',
            'semester' => 'الثاني',
            'prerequisite_subject_id' => 2, // الرياضيات الأساسية
            'units' => 3,
        ]);

        // مواد الفصل الثالث
        Subject::create([
            'name' => 'قواعد البيانات',
            'semester' => 'الثالث',
            'prerequisite_subject_id' => 4, // برمجة متقدمة
            'units' => 4,
        ]);

        Subject::create([
            'name' => 'شبكات الحاسوب',
            'semester' => 'الثالث',
            'prerequisite_subject_id' => 4, // برمجة متقدمة
            'units' => 3,
        ]);

        Subject::create([
            'name' => 'تحليل وتصميم النظم',
            'semester' => 'الثالث',
            'prerequisite_subject_id' => 5, // هياكل البيانات
            'units' => 3,
        ]);

        // مواد الفصل الرابع
        Subject::create([
            'name' => 'تطوير تطبيقات الويب',
            'semester' => 'الرابع',
            'prerequisite_subject_id' => 7, // قواعد البيانات
            'units' => 4,
        ]);

        Subject::create([
            'name' => 'أمن المعلومات',
            'semester' => 'الرابع',
            'prerequisite_subject_id' => 8, // شبكات الحاسوب
            'units' => 3,
        ]);

        Subject::create([
            'name' => 'ذكاء اصطناعي',
            'semester' => 'الرابع',
            'prerequisite_subject_id' => 6, // الإحصاء والاحتمالات
            'units' => 3,
        ]);
    }
} 