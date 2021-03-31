<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public static function validationRules($id = null)
    {
        return [
            'name' => 'required',
            'siret' => 'required|unique:companies,id,' . $id,
            'iban' => 'required|unique:companies,id,' . $id,
        ];
    }

    protected $guarded = ['id'];
    /*
    protected $fillable = [
        'name',
        'siret',
        'country',
        'iban',
    ];
    */

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = [
    ];
}

