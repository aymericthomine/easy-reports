<?php

namespace App\Mail;

use App\Models\CampaignNotif;
use App\Models\Contact;
use App\Models\Error;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class MailjetMessage extends MailMessage
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $contact_id = null, $campaign_id = null )
    {
        $customId = 0;

        if( $contact_id && $campaign_id ){
             $campaignNotif = CampaignNotif::create([
                                                    'contact_id'    => $contact_id,
                                                    'campaign_id'   => $campaign_id,
                                                ]);
            $customId = $campaignNotif->id;
        }

        Log::debug('MailjetMessage->__construct add customID to header: ' . $customId);

        $this->withSwiftMessage( function($swiftmessage) use ($customId) {
                    $swiftmessage->getHeaders()->addTextHeader( 'X-MJ-CustomID', $customId );
                });
        return $this;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }

    /**
     * @param Request $request
     *
     * Store Mailjet event
     * see web.php: Route:post('/mailjet)
     * Mailjet Webhooks configuration: https://app.mailjet.com/account/triggers
     *
     * Store MailJet Events into campaign_notifs table
     * many event may be sent at a time, so we create 1 record per event
     * the customID make the link with the events created when send to Mailjet
     * CustomID = campaign_id | contact_id | contact_from | email_to
     */
    public static function storeEvents(Request $request)
    {
        try {
            /**
             * array transformation to manage single ant grouped events
             * single to grouped: {"event":...} => [{"event":...}]
             * grouped remain: [{"event":...},{"event":...}]
             */
            $events = Arr::isAssoc( $request->all() ) ? array( $request->all() ) : $request->all();

            foreach ($events as $e)
            {
                $event = strtolower( $e['event'] );

                if( in_array( $event, CampaignNotif::validEvents()) ) {
                    $campaignNotif = CampaignNotif::updateOrCreate( [ 'id' => $e['CustomID'], ], [] );

                    if( $campaignNotif ) {
                        $campaignNotif->$event ++;
                        $campaignNotif->request .= json_encode($e);
                        $campaignNotif->save();
                    }

                    if( in_array( $event, CampaignNotif::errorEvents()) ) {
                        Log::debug('MailjetMessage->storeEvents errorEvent: ' . $event . ' / ' . $e['email'] );
                        Error::updateOrCreate(  [ 'email'        => $e['email'], ],
                                                [ 'contact_id'   => $campaignNotif->contact_id,
                                                  'status'       => $event,     ]);
                        Contact::where('email', $e['email'] )->update(array('email_status' => $event));
                    }
                }
            }
        }
        catch (\Throwable $e) { }
    }

}
