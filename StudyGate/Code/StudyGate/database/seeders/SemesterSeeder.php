<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Semester;
use Carbon\Carbon;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء فصول دراسية تجريبية
        
        // فصل خريف 2023 (منتهي)
        Semester::create([
            'name' => 'فصل الخريف 2023',
            'start_date' => '2023-09-01',
            'end_date' => '2024-01-15',
            'is_active' => false,
            'enrollment_open' => false,
        ]);

        // فصل ربيع 2024 (منتهي)
        Semester::create([
            'name' => 'فصل الربيع 2024',
            'start_date' => '2024-02-01',
            'end_date' => '2024-06-15',
            'is_active' => false,
            'enrollment_open' => false,
        ]);

        // فصل خريف 2024 (منتهي)
        Semester::create([
            'name' => 'فصل الخريف 2024',
            'start_date' => '2024-09-01',
            'end_date' => '2025-01-15',
            'is_active' => false,
            'enrollment_open' => false,
        ]);

        // فصل ربيع 2025 (حالي)
        Semester::create([
            'name' => 'فصل الربيع 2025',
            'start_date' => '2025-02-01',
            'end_date' => '2025-06-15',
            'is_active' => true,
            'enrollment_open' => false,
        ]);

        // فصل خريف 2025 (متاح للتسجيل)
        Semester::create([
            'name' => 'فصل الخريف 2025',
            'start_date' => '2025-09-01',
            'end_date' => '2026-01-15',
            'is_active' => false,
            'enrollment_open' => true,
        ]);
    }
} 