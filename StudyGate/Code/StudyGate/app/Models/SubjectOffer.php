<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectOffer extends Model
{
    protected $fillable = [
        'subject_id',
        'teacher_id',
        'semester_id'
    ];

    // العلاقة مع المادة
    public function subject()
    {
        //(Subjec::class = Select from (Subject) ) and the foregin key between them which is subjectOffers.subject_id = (Subject::class id)
        // so its like SELECT * FROM subjects WHERE id = subject_offers.subject_id;

        return $this->belongsTo(Subject::class, 'subject_id'); // ---each subjectOFFER - > belongs to 1 subject
        //we're defining a relationship pointing outward from SubjectOffer → to Subject
    }

    // العلاقة مع المدرس
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // العلاقة مع الفصل الدراسي
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    // العلاقة مع التسجيلات
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // العلاقة مع جدول الحصص
  public function schedules()
    {
        return $this->hasMany(ClassSchedule::class);
    }


    // العلاقة مع جدول الامتحانات
    public function examSchedules()
    {
        return $this->hasMany(ExamSchedule::class);
    }


    public function subjectInfo()
{
    return $this->belongsTo(Subject::class, 'subject_id');
}
public function students()
{
    return $this->belongsToMany(
        User::class,   
        'enrollments',               
        'subject_offer_id',         
        'student_id'                 
    )->where('role', 'student');      
}




}
