<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'address',
        'gender',
        'birthdate',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthdate' => 'date',
        ];
    }

    //----------------------added manually---------------------
    public function enrollments()
{
    return $this->hasMany(Enrollment::class, 'student_id');
}
// For teachers
public function teachingSubjects()
{
    return $this->hasMany(SubjectOffer::class, 'teacher_id');
}

// For students
public function semesterStarts()
{
    return $this->hasMany(SemesterStart::class, 'student_id');
}

public function subjectRequests()
{
    return $this->hasMany(SubjectRequest::class, 'student_id');
}

// Helper methods for students
public function getCurrentSemesterUnits()
{
    // البحث عن الفصل المسجل فيه الطالب أولاً
    $semesterStart = \App\Models\SemesterStart::where('student_id', $this->id)
        ->whereHas('semester', function($query) {
            $query->where(function($subQuery) {
                $subQuery->where('is_active', true)
                         ->orWhere('enrollment_open', true);
            });
        })
        ->with('semester')
        ->orderBy('created_at', 'desc')
        ->first();

    $registeredSemester = $semesterStart ? $semesterStart->semester : null;
    
    // إذا لم يكن مسجلاً في أي فصل، البحث عن الفصل النشط (للتوافق مع النظام القديم)
    if (!$registeredSemester) {
        $registeredSemester = \App\Models\Semester::where('is_active', true)->first();
    }
    
    if (!$registeredSemester) {
        return 0;
    }
    
    return $this->enrollments()
        ->whereHas('subjectOffer', function($query) use ($registeredSemester) {
            $query->where('semester_id', $registeredSemester->id);
        })
        ->with('subjectOffer.subject')
        ->get()
        ->sum(function($enrollment) {
            return $enrollment->subjectOffer->subject->units ?? 0;
        });
}

public function canEnrollInUnits($units)
{
    $currentUnits = $this->getCurrentSemesterUnits();
    $maxUnits = config('academic.unit_limits.max_units_per_semester', 18);
    
    return ($currentUnits + $units) <= $maxUnits;
}

public function getAvailableUnits()
{
    $currentUnits = $this->getCurrentSemesterUnits();
    $maxUnits = config('academic.unit_limits.max_units_per_semester', 18);
    
    return max(0, $maxUnits - $currentUnits);
}
//كل مدرس هنده اكتر من مادة 
public function subjectOffers()
{
    return $this->hasMany(SubjectOffer::class, 'teacher_id');
}


}
