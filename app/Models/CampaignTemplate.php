<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignTemplate extends Model
{
    use HasFactory;

    public static function validationRules($id = null)
    {
        return [
            'name'              => 'required|unique:campaign_templates,id,' . $id,
            'subject_1_fr'      => 'required',
            'subject_2_fr'      => 'nullable',
            'subject_1_en'      => 'nullable',
            'subject_2_en'      => 'nullable',
            'greetings_1_fr'    => 'nullable',
            'greetings_2_fr'    => 'nullable',
            'greetings_1_en'    => 'nullable',
            'greetings_2_en'    => 'nullable',
            'line1_1_fr'        => 'required',
            'line1_2_fr'        => 'nullable',
            'line1_1_en'        => 'nullable',
            'line1_2_en'        => 'nullable',
            'line2_1_fr'        => 'nullable',
            'line2_2_fr'        => 'nullable',
            'line2_1_en'        => 'nullable',
            'line2_2_en'        => 'nullable',
            'salutations_1_fr'  => 'nullable',
            'salutations_2_fr'  => 'nullable',
            'salutations_1_en'  => 'nullable',
            'salutations_2_en'  => 'nullable',
            'view_1_fr'         => 'nullable',
            'view_2_fr'         => 'nullable',
            'view_1_en'         => 'nullable',
            'view_2_en'         => 'nullable',
            'link'              => 'nullable',
            'attachment_fr'     => 'nullable',
            'attachment_en'     => 'nullable',
            'image'             => 'nullable',
            'unsubscribe'       => 'nullable',
        ];
    }

    public static function fieldList()
    {
        return [
            'subject',
            'greetings',
            'line1',
            'line2',
            'salutations',
            'view',
        ];
    }

    protected $guarded = ['id'];

    /*
    protected $fillable = [
        'name',
        'view',
    ];
    */

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = [
    ];
}
