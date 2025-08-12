<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubjectOffer;
use App\Models\Enrollment;
use App\Models\GradeRecord;
use App\Models\User;
use App\Models\Subject;
use App\Models\Semester;

class SubjectOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // جلب المستخدمين
        $teachers = User::where('role', 'teacher')->get();
        $students = User::where('role', 'student')->get();
        $subjects = Subject::all();
        $semesters = Semester::all();

        // إنشاء عروض مواد للفصول السابقة
        foreach ($semesters->take(3) as $semester) { // الفصول الثلاثة الأولى
            foreach ($subjects->take(6) as $subject) { // أول 6 مواد
                $subjectOffer = SubjectOffer::create([
                    'subject_id' => $subject->id,
                    'teacher_id' => $teachers->random()->id,
                    'semester_id' => $semester->id,
                ]);

                // تسجيل بعض الطلاب في هذه المادة
                $enrolledStudents = $students->random(rand(2, 4));
                foreach ($enrolledStudents as $student) {
                    $enrollment = Enrollment::create([
                        'student_id' => $student->id,
                        'subject_offer_id' => $subjectOffer->id,
                        'enrolled_at' => now(),
                    ]);

                    // إضافة درجات للفصول المنتهية
                    if ($semester->end_date < now()) {
                        GradeRecord::create([
                            'enrollment_id' => $enrollment->id,
                            'grade' => rand(60, 100) / 10, // درجة بين 6.0 و 10.0
                        ]);
                    }
                }
            }
        }

        // إنشاء عروض مواد للفصل الحالي
        $currentSemester = $semesters->where('is_active', true)->first();
        if ($currentSemester) {
            foreach ($subjects->take(4) as $subject) { // أول 4 مواد
                $subjectOffer = SubjectOffer::create([
                    'subject_id' => $subject->id,
                    'teacher_id' => $teachers->random()->id,
                    'semester_id' => $currentSemester->id,
                ]);

                // تسجيل بعض الطلاب في هذه المادة
                $enrolledStudents = $students->random(rand(1, 3));
                foreach ($enrolledStudents as $student) {
                    Enrollment::create([
                        'student_id' => $student->id,
                        'subject_offer_id' => $subjectOffer->id,
                        'enrolled_at' => now(),
                    ]);
                }
            }
        }
    }
} 