<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lab;

class LabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lab::create([
            'building_id' => 1, // تأكد أن لديك مبنى بهذا الـ id
            'room_number' => '101',
            'description' => 'مختبر حاسوب رئيسي',
        ]);

        Lab::create([
            'building_id' => 1,
            'room_number' => '102',
            'description' => 'مختبر شبكات',
        ]);

        Lab::create([
            'building_id' => 2,
            'room_number' => '201',
            'description' => 'مختبر فيزياء',
        ]);
    }
}
