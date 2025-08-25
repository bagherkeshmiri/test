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

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function notificationPreference(): HasOne
    {
        return $this->hasOne(NotificationPreference::class);
    }


    public function hasActivePhoneNumber(): bool
    {
        return !empty($this->phone_number);
    }


    public function preferredLocale(): string
    {
        return $this->locale ?: app()->getLocale();
    }
}
