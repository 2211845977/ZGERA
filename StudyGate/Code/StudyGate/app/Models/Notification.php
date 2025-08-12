<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',      // lecture, announcement, task
        'title',
        'body',
        'user_id',   // يمكن أن يكون null إذا الإشعار عام
        'is_read'
    ];
}
