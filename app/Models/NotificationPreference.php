<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'default_channel',
        'channels_per_event',
    ];


    protected $casts = [
        'channels_per_event' => 'array',
    ];
}
