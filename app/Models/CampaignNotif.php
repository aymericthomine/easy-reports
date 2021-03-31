<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class CampaignNotif extends Model
{
    use HasFactory;

    public static function validationRules($id = null)
    {
        return [
        ];
    }

    public static function validEvents()
    {
        return [
            'sent',
            'open',
            'click',
            'bounce',
            'spam',
            'blocked',
            'unsub',
        ];
    }

    public static function errorEvents()
    {
        return [
            'bounce',
            'spam',
            'blocked',
            'unsub',
        ];
    }

    protected $guarded = ['id'];
    /*
    protected $fillable = [
        'campaign_id',
        'contact_id',
        'sent',
        'open',
        'click',
        'bounce',
        'spam',
        'blocked',
        'unsub',
        'request',
    ];
    */

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = [
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
