<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    use HasFactory;

    public static function validationRules($id = null)
    {
        return [
            'email'     => 'required|email|unique:errors,id,' . $id,
            'status'    => 'required',

        ];
    }

    protected $guarded = ['id'];
    /*


    */

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = [
    ];

}
