<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'student_id',
        'subject_offer_id',
        'enrolled_at',


    ];

    protected $casts = [
        'enrolled_at' => 'datetime'
    ];

    // العلاقة مع الطالب
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // العلاقة مع عرض المادة
    public function subjectOffer()
    {
        return $this->belongsTo(SubjectOffer::class);
    }

    // العلاقة مع سجل الدرجات
    public function gradeRecord()
    {
        return $this->hasOne(GradeRecord::class);
    }
}
