<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    use HasFactory;
    use Notifiable;

    public static function validationRules($id = null)
    {
        return [
            'name'        => 'required',
            'firstname'   => 'required',
            'gender'      => 'required',
            'class'       => 'required',
        ];
    }

    protected $guarded = ['id'];
    /*
    protected $fillable = [
        'company_id',
        'name',
        'firstname',
        'proximity',
        'phone',
        'email',
        'role',
    ];
    */

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = [
    ];


}
