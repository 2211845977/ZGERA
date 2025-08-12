<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectRequest extends Model
{
    protected $fillable = [
        'student_id',
        'enrollment_id',
        'request_type',
        'reason',
        'status',
        'admin_notes',
        'requested_at',
        'processed_at'
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    // العلاقة مع الطالب
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // العلاقة مع التسجيل
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    // العلاقة مع المادة من خلال التسجيل
    public function subject()
    {
        return $this->hasOneThrough(
            Subject::class,
            Enrollment::class,
            'id',
            'id',
            'enrollment_id',
            'subject_offer_id'
        );
    }

    // Scopes للفلترة
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeDropRequests($query)
    {
        return $query->where('request_type', 'drop');
    }

    public function scopeEnrollRequests($query)
    {
        return $query->where('request_type', 'enroll');
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isDropRequest()
    {
        return $this->request_type === 'drop';
    }

    public function isEnrollRequest()
    {
        return $this->request_type === 'enroll';
    }
}
