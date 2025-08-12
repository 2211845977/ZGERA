<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubjectRequest;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Semester;

class SubjectRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // جلب الطلاب والتسجيلات
        $students = User::where('role', 'student')->get();
        $currentSemester = Semester::where('is_active', true)->first();
        
        if (!$currentSemester) {
            return;
        }
        
        // إنشاء طلبات إسقاط تجريبية
        foreach ($students->take(2) as $student) {
            $enrollments = Enrollment::where('student_id', $student->id)
                ->whereHas('subjectOffer', function($query) use ($currentSemester) {
                    $query->where('semester_id', $currentSemester->id);
                })
                ->get();
            
            if ($enrollments->isNotEmpty()) {
                $enrollment = $enrollments->first();
                
                SubjectRequest::create([
                    'student_id' => $student->id,
                    'enrollment_id' => $enrollment->id,
                    'request_type' => 'drop',
                    'reason' => 'أجد صعوبة في المادة وأريد إسقاطها',
                    'status' => 'pending',
                    'requested_at' => now(),
                ]);
            }
        }
        
        // إنشاء طلب معتمد
        $approvedEnrollment = Enrollment::whereHas('subjectOffer', function($query) use ($currentSemester) {
            $query->where('semester_id', $currentSemester->id);
        })->with('student')->first();
        
        if ($approvedEnrollment) {
            SubjectRequest::create([
                'student_id' => $approvedEnrollment->student_id,
                'enrollment_id' => $approvedEnrollment->id,
                'request_type' => 'drop',
                'reason' => 'تعارض في المواعيد',
                'status' => 'approved',
                'admin_notes' => 'تم الموافقة على الطلب',
                'requested_at' => now()->subDays(5),
                'processed_at' => now()->subDays(2),
            ]);
        }
    }
}
