<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    use HasFactory;

    public static function validationRules($id = null)
    {
        return [
            /*
            'name'          => 'required',
            'description'   => 'required',
            'format'        => 'required',
            'version'       => 'required',
            'file'          => 'required',
            // 'file'       => 'required|mimes:doc,docx,csv,txt,xlx,xls,pdf|max:1024',
            */
        ];
    }

    protected $guarded = ['id'];
    /*
        protected $fillable = [
            'A',
            'B',
            'C',
        ];
    */

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = [
    ];
}
