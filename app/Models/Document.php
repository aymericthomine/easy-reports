<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    public static function validationRules($id = null)
    {
        return [
            'name'          => 'required|unique:documents,id,' . $id,
            'description'   => 'required',
            'format'        => 'required',
            'version'       => 'required',
            'file'          => 'required',
            // 'file'       => 'required|mimes:doc,docx,csv,txt,xlx,xls,pdf|max:1024',
        ];
    }

    protected $guarded = ['id'];
    /*
    protected $fillable = [
        'name',
        'description',
        'format',
        'version',
        'file',
    ];
    */

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = [
    ];
}
