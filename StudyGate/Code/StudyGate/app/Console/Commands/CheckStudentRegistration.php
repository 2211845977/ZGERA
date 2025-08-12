<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Semester;
use App\Models\SemesterStart;

class CheckStudentRegistration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:check-registration {email : البريد الإلكتروني للطالب}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'فحص وإصلاح تسجيل الطالب في الفصل الدراسي';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        // البحث عن الطالب
        $student = User::where('email', $email)
                      ->where('role', 'student')
                      ->first();
        
        if (!$student) {
            $this->error("لا يوجد طالب بالبريد الإلكتروني: {$email}");
            return 1;
        }
        
        $this->info("تم العثور على الطالب: {$student->name} (ID: {$student->id})");
        
        // البحث عن فصل خريف 2025
        $fall2025 = Semester::where('name', 'فصل الخريف 2025')
                           ->where('enrollment_open', true)
                           ->first();
        
        if (!$fall2025) {
            $this->error("فصل خريف 2025 غير متاح أو غير موجود");
            return 1;
        }
        
        $this->info("فصل خريف 2025 متاح للتسجيل");
        $this->info("- تاريخ البداية: {$fall2025->start_date}");
        $this->info("- تاريخ النهاية: {$fall2025->end_date}");
        
        // فحص ما إذا كان الطالب مسجل في الفصل
        $registration = SemesterStart::where('student_id', $student->id)
                                    ->where('semester_id', $fall2025->id)
                                    ->first();
        
        if ($registration) {
            $this->info("الطالب مسجل بالفعل في فصل خريف 2025");
            $this->info("- تاريخ التسجيل: {$registration->started_at}");
        } else {
            $this->warn("الطالب غير مسجل في فصل خريف 2025");
            
            if ($this->confirm('هل تريد تسجيل الطالب في فصل خريف 2025؟')) {
                SemesterStart::create([
                    'student_id' => $student->id,
                    'semester_id' => $fall2025->id,
                    'started_at' => now()
                ]);
                
                $this->info("تم تسجيل الطالب في فصل خريف 2025 بنجاح!");
            }
        }
        
        // فحص المواد المتاحة في الفصل
        $subjectOffersCount = \App\Models\SubjectOffer::where('semester_id', $fall2025->id)->count();
        $this->info("عدد المواد المتاحة في فصل خريف 2025: {$subjectOffersCount}");
        
        if ($subjectOffersCount > 0) {
            $this->info("✅ يجب أن يتمكن الطالب الآن من رؤية المواد المتاحة");
        } else {
            $this->error("❌ لا توجد مواد متاحة في فصل خريف 2025");
        }
        
        return 0;
    }
} 