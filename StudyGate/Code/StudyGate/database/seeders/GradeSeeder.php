<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\GradeRecord;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $subjectOfferIds = [24, 26, 27, 29];

        $enrollments = Enrollment::whereIn('subject_offer_id', $subjectOfferIds)->get();

        foreach ($enrollments as $enrollment) {
            GradeRecord::updateOrCreate(
                ['enrollment_id' => $enrollment->id],
                [
                    'first_exam' => rand(15, 20),
                    'second_exam' => rand(15, 20),
                    'final_exam' => rand(40, 50),
                    'total_grade' => 0,
                ]
            );
        }

        foreach (GradeRecord::all() as $record) {
            $record->total_grade = $record->first_exam + $record->second_exam + $record->final_exam;
            $record->save();

        }
        //
    }
}
