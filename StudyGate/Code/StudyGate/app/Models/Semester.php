<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{

    protected $fillable=[
         'name',
        'start_date',
        'end_date',
        'is_active',
        'enrollment_open',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'enrollment_open' => 'boolean'
    ];

    // العلاقة مع عروض المواد
    public function subjectOffers()
    {
        return $this->hasMany(SubjectOffer::class);
    }

    // العلاقة مع بدايات الفصول للطلاب
    public function semesterStarts()
    {
        return $this->hasMany(SemesterStart::class);
    }
}
