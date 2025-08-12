<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSchedule extends Model
{
    protected $fillable = [
        'subject_offer_id',
        'exam_type',
        'exam_date',
        'session',
        'room',
    ];

    /**
     * العلاقة: جدول الامتحانات مرتبط بعرض مادة
     */
    public function subjectOffer(): BelongsTo
    {
        return $this->belongsTo(SubjectOffer::class);
    }
}
