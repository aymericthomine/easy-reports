<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

/*
 * ATTENTION: inherit from MailjetMailable
 * in order to add X-MJ-CustomID to the header
 */
class ContactUs extends MailjetMailable
{
    use Queueable, SerializesModels;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build( $contact_id = null, $campaign_id = null )
    {
        Log::debug('ContactUs->build: ' . $contact_id .' / '. $campaign_id);

        return parent::build( $this->data['contact']->id, $this->data['campaign']->id )
                        ->from(     config('mail.from.address') )
                        ->to(       config('mail.from.address') )
                        ->subject( 'Customer Request' )
                        ->view( 'contact-us.template_email' )
                        ->with( 'data', $this->data );
    }
}
