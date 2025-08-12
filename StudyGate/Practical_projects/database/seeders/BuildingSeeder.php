<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Building;
use App\Models\Campus;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الحصول على أول حرم جامعي
        $campus = Campus::first();

        if (!$campus) {
            // إنشاء حرم جامعي افتراضي إذا لم يكن موجوداً
            $campus = Campus::create(['name' => 'الحرم الرئيسي']);
        }

        $buildings = [
            ['name' => 'مبنى العلوم', 'campus_id' => $campus->id],
            ['name' => 'مبنى الهندسة', 'campus_id' => $campus->id],
            ['name' => 'مبنى الطب', 'campus_id' => $campus->id],
            ['name' => 'مبنى الإدارة', 'campus_id' => $campus->id],
            ['name' => 'مبنى المكتبة', 'campus_id' => $campus->id],
        ];

        foreach ($buildings as $building) {
            Building::create($building);
        }
    }
}
