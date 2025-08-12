<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
protected $fillable = ['name', 'prerequisite_subject_id', 'semester', 'units'];


public function prerequisite()
{
    return $this->belongsTo(Subject::class, 'prerequisite_subject_id');
}

public function dependents()
{
    return $this->hasMany(Subject::class, 'prerequisite_subject_id');
}

public function subjectOffers()
{
    return $this->hasMany(SubjectOffer::class);
}


}
