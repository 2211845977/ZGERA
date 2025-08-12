<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemesterStart extends Model
{
    protected $fillable = [
        'student_id',
        'semester_id',
        'started_at'
    ];

    protected $casts = [
        'started_at' => 'datetime'
    ];

    // العلاقة مع الطالب
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // العلاقة مع الفصل الدراسي
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
