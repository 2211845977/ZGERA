<?php

// app/Models/Lab.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $fillable = ['building_id', 'room_number', 'description'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}

