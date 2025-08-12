<?php

// namespace App\Observers;

// use App\Models\Enrollment;
// use App\Models\GradeRecord;

// class EnrollmentObserver
// {
//     public function created(Enrollment $enrollment): void
//     {
//         GradeRecord::firstOrCreate(
//             ['enrollment_id' => $enrollment->id],
//             [
//                 'first_exam' => 0,
//                 'second_exam' => 0,
//                 'final_exam' => 0,
//                 'total_grade' => 0,
//             ]
//         );
//     }
// }
