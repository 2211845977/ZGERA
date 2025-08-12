<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ClassSchedule extends Model
{
    protected $fillable = ['subject_offer_id', 'day_of_week', 'session', 'room'];


    /**
     * العلاقة: جدول الحصص مرتبط بعرض مادة
     */
    public function subjectOffer()
    {
        return $this->belongsTo(SubjectOffer::class);
    }   
}
