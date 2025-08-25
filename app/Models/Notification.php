<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\DatabaseNotification as BaseNotification;


class Notification extends BaseNotification
{
    public const string TABLE_NAME = 'notifications';
    protected $table = self::TABLE_NAME;
    public const string COLUMN_ID = 'id';

    protected $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    /*------------ Relations ------------*/

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /*-------------- Accessors & Mutators -------------*/

    /*-------------- Scopes -------------*/

    /*---------- Other Functions --------*/


}
