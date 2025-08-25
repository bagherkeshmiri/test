<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    public const string TABLE_NAME = 'users';
    protected $table = self::TABLE_NAME;
    public const string COLUMN_ID = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'locale'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
    ];

    /*------------ Relations ------------*/

    public function notificationPreference(): HasOne
    {
        return $this->hasOne(NotificationPreference::class, NotificationPreference::COLUMN_USER_ID, self::COLUMN_ID);
    }

    /*-------------- Accessors & Mutators -------------*/

    public function hasActivePhoneNumber(): bool
    {
        return !empty($this->phone_number);
    }

    public function preferredLocale(): string
    {
        return $this->locale ?: app()->getLocale();
    }

    /*-------------- Scopes -------------*/


    /*---------- Other Functions --------*/


}
