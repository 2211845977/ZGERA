<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeRecord extends Model
{
    protected $fillable = [
        'enrollment_id',
        'grade'
    ];

    protected $casts = [
        'grade' => 'float'
    ];

    // العلاقة مع التسجيل
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
