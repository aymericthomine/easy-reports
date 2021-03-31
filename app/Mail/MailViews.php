<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MailViews extends MailjetMailable
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        Log::debug('MailViews build: ' );

        return parent::build()
                        ->from( $this->data['from_email'], $this->data['from_name'])
                        ->to( $this->data['to_email'] )
                        ->subject( $this->data['subject'] )
                        ->view( $this->data['view'] )
                        ->with( 'data', $this->data );
    }
}
