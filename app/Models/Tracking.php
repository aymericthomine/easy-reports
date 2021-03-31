<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    public static function validationRules($id = null)
    {
        return [
        ];
    }

    protected $guarded = ['id'];
    /*
    protected $fillable = [
        'ip',
        'user_agent',
        'accept_language',
        'user_ip',
        'for',
        'country',
        'region',
        'city',
        'city_lat_long',
    ];
    */

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = [
    ];
}
