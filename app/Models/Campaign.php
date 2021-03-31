<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    public static function validationRules($id = null)
    {
        return [
            'name'          => 'required|unique:campaigns,id,' . $id,
            'description'   => 'required',
        ];
    }

    protected $guarded = ['id'];
    /*
    protected $fillable = [
        'name',
        'description',
    ];
    */

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = [
    ];

    public function campaignNotifs()
    {
        return $this->hasMany(CampaignNotif::class);
    }
}
