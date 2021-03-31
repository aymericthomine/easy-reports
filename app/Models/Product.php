<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasFactory;
    use HasApiTokens;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    public static function validationRules($id = null)
    {
        return [
            'product.name'          => 'required|unique:products,id,' . $id,
            'product.description'   => 'nullable',
            'product.reward'        => 'nullable',
            /*
            'name'          => 'required',
            'description'   => 'required',
            'reward'        => 'required',
            */
        ];
    }

    protected $guarded = ['id'];
    /*
    protected $fillable = [
        'name',
        'description',
        'reward',
    ];
    */

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = [
    ];
}
