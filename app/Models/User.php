<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $appends = ['is_sub_admin'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'fcm_token',
        'isOnline',
        'Access_Role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'fcm_token',
        // 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }

    /**
     * Accessor so Access_Role works whether DB column is access_role or Access_Role.
     */
    public function getAccessRoleAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }
        return $this->attributes['access_role'] ?? null;
    }

    protected function isSubAdmin(): Attribute
    {
        $user= Employee::find(auth()->user()->id);
        return Attribute::make(
            get: fn () => (int) ($user->Access_Role ?? 0) === 2
        );
    }
}
