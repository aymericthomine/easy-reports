<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    public static function validationRules($id = null)
    {
        return [
            'name'      => 'required|unique:users,id,' . $id,
            'email'     => 'required|email|unique:users,id,' . $id,
            'role'      => 'required',
            'password'  => 'required',
        ];
    }
    protected $guarded = ['id'];
    /*
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];
    */

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = [
    ];
}
