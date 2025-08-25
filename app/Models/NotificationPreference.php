<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    public const string TABLE_NAME = 'notification_preferences';
    protected $table = self::TABLE_NAME;
    public const string COLUMN_ID = 'id';
    public const string COLUMN_USER_ID = 'user_id';

    protected $fillable = [
        'user_id',
        'default_channel',
        'channels_per_event',
    ];

    protected $hidden = [];

    protected $casts = [
        'channels_per_event' => 'array',
    ];

    /*------------ Relations ------------*/

    /*-------------- Accessors & Mutators -------------*/

    /*-------------- Scopes -------------*/

    /*---------- Other Functions --------*/


}
