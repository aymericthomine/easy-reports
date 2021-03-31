<?php

namespace App\Notifications;

use App\Mail\MailjetMailable;
use App\Mail\MailjetMessage;
use App\Models\CampaignNotif;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mime\Header\MailboxListHeader;

class Mailable_mailjet extends Notification implements ShouldQueue
{
    use Queueable;

    public $data = [];
    public $signature;
    public $image;

    public function __construct( array $data = [] )
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subcopy    = null;
        $lang       = $this->data['contact']->language  ? $this->data['contact']->language  : 'en';
        $prox       = $this->data['contact']->proximity ? $this->data['contact']->proximity : 1;
        $prox       = $prox ."_". $lang;
        $name       = $this->data['contact']->firstname;
        $from       = $this->data['from']->firstname;
        $firstname  = explode('@', $this->data['from']->email);
        $signature  = "$firstname[0].txt";
        $signature  = "$firstname[0].png";
        $signature  = "$firstname[0].jpg";
        $this->signature  = $firstname[0];
        $view       = $this->data['campaign_template']->image;
//        $image      = $view .'.jpg';
        $this->image      = $view;

        if ( $prox > 1 ) {
            $name .= " ". $this->data['contact']->name;
            $from .= " ". $this->data['from'   ]->name;
        }

        // $mail = new MailjetMessage( $this->data['contact']->id, $this->data['campaign']->id );
        $mail = new MailjetMailable( $this->data['contact']->id, $this->data['campaign']->id );
/*
        if( null == $view ) {
            $mail->markdown('vendor.notifications.email', ['image' => $this->image, 'signature' => $this->signature] );
        } else {
            $mail->markdown('emails.'. $view            , ['image' => $this->image, 'signature' => $this->signature] );
        }
*/
        $mail->from( $this->data['from']->email, $this->data['from']->firstname ." ". $this->data['from']->name );
$mail->view( 'emails.test_embed' )->with(['image' => $this->image, 'signature' => $this->signature]);
$mail->send();
        $subject = $this->data['campaign_template']->{"subject_$prox"};
        if( $subject ){ $mail->subject($subject); }
/*
        $greeting = $this->data['campaign_template']->{"greetings_$prox"};
        if( $greeting ){ $mail->greeting($greeting ." ". $name ."," ); }

        $lines = explode('.', $this->data['campaign_template']->{"line1_$prox"} );
        foreach($lines as $line) {
            if( $line ) { $mail->line($line .'.' ); }
        }

        $link = $this->data['campaign_template']->link;
        if( $link ){ $mail->action(url($link), url($link) ); }

        $lines = explode('.', $this->data['campaign_template']->{"line2_$prox"} );
        foreach($lines as $line) {
            if( $line ) { $mail->line($line .'.' ); }
        }

        $salutations = $this->data['campaign_template']->{"salutations_$prox"};
        if( $salutations ){ $mail->salutation($salutations ."\n\r". $from ); }
*/
        return $mail;
    }
}
