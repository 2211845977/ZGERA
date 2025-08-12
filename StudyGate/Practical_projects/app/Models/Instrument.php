<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{



    protected $fillable = [
        'lab_id',
        'name',
        'purpose',
        'description',
        'serial_number',
        'model',
        'experiment_types',
        'analysis_types',
        'status',
        'required_materials',
        'responsible_person',
    ];

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }
}
