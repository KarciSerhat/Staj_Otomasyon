<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'userUID',
        'userFullName',
        'userFirstName',
        'userLastName',
        'userEMailAddress',
        'userLogonName',
        'userOfficeLocation',
        'userTitle',
        'userTelephoneNumber',
        'userGender',
        'userDescription',
        'userLogonNamePreWindows2000',
        'userDistinguishedName',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getApplication () {
        return $this->hasOne('App\Models\Application', 'student_id', 'id');
    }
}
