<?php

namespace App\Mail;

use App\Models\CampaignNotif;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class MailjetMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /*
     * Add X-MJ-CustomID to the header of all outgoing mail
     * All mailable must inherit from this class
     */
    public function build( $contact_id = null, $campaign_id = null )
    {
        $customId = 0;

        if( $contact_id && $campaign_id ){
            $campaignNotif = CampaignNotif::create([
                                                    'contact_id'    => $contact_id,
                                                    'campaign_id'   => $campaign_id,
                                                ]);
            $customId = $campaignNotif->id;
        }

        Log::debug('MailjetMailable->build add customID to header: ' . $customId .' / '. $contact_id);

        $this->withSwiftMessage(function($swiftmessage) use ($customId) {
                    $swiftmessage->getHeaders()->addTextHeader('X-MJ-CustomID', $customId );
                });
        return $this;
    }

    /*
     * Store Mailjet event
     * See class MailjetMessage
     * see web.php: Route:post('/mailjet)
     * Mailjet Webhooks configuration: https://app.mailjet.com/account/triggers
     */
    // public static function store(Request $request)
}
