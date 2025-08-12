<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    

    protected $fillable = ['campus_id', 'name'];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function labs()
    {
        return $this->hasMany(Lab::class);
    }
}
