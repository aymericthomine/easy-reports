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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Livewire\WithFileUploads;
use Symfony\Component\Mime\Header\MailboxListHeader;
use App\Http\Livewire\CustomizedDocuments;
use MBence\OpenTBSBundle\Services\OpenTBS;
use clsOpenTBS;
use clsTinyButStrong;


class CampaignNotification extends Notification implements ShouldQueue
{
    use Queueable;
    use WithFileUploads;

    public $data = [];
    public $signature;
    public $image;
    public $contract;
    public $file;
    public $attachment_fr;

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
        $lang           = strtolower( $this->data['contact']->language  ? $this->data['contact']->language  : 'en' );
        $prox           = $this->data['contact']->proximity ? $this->data['contact']->proximity : 1;
        $prox           = $prox ."_". $lang;
        $attachment     = $this->data['campaign_template']->{"attachment_$lang"};
        $signature      = explode('@', $this->data['from']->email);
        $signature      = $signature[0];
        $toProximity    = $this->data['contact']->firstname;
        $fromProximity  = $this->data['from'   ]->firstname;
        $unsubscribeUrl = '';

        /* Annule par Manuel a la demande de Sebastien
        if ( $prox > 1 ) {
            $toProximity     .= " ". $this->data['contact']->name;
            $fromProximity   .= " ". $this->data['from'   ]->name;
        }
        */

        /**
         * Attention, si le contact est taggué "unsubscribe", pas d'envoi de mail
         *
         *
         */

        if($this->data['contact']->email_status != 'unsub') {

            if ($this->data['campaign_template']->unsubscribe == true) {

                $unsubscribeUrl = URL::signedRoute('users.unsubscribe', ['user' => $this->data['contact']->id]);
            }

            // $mail = new MailjetMessage( $this->data['contact']->id, $this->data['campaign_template']->id, $this->data['from']->id );
            $mail = new MailjetMessage($this->data['contact']->id, $this->data['campaign']->id);
            $mail->from($this->data['from']->email, $this->data['from']->firstname . " " . $this->data['from']->name);
            $mail->subject($this->data['campaign_template']->{"subject_$prox"});

            $mail->markdown('emails.template', [
                'toProximity' => $toProximity,
                'greetings' => $this->data['campaign_template']->{"greetings_$prox"},
                'line1' => $this->data['campaign_template']->{"line1_$prox"},
                'line2' => $this->data['campaign_template']->{"line2_$prox"},
                'salutations' => $this->data['campaign_template']->{"salutations_$prox"},
                'linkLabel' => $this->data['campaign_template']->link,
                'link' => url('links/' . $this->data['campaign_template']->link . '/' . $this->data['contact']->id),
                'fromName' => $this->data['from']->firstname . ' ' . $this->data['from']->name,
                'fromProximity' => $fromProximity,
                'signature' => $signature,
                'lang' => $lang,
                'unsubscribe' => $unsubscribeUrl,
            ]);

            if ($attachment) {

                $contract = new CustomizedDocuments();
                $customizedContract = $contract->customizeCMContract(
                    array(
                        /* Council Member */
                        'firstname' => $this->data['contact']->firstname,

                        /* MOLITOR */
                        // 'fromName' => $this->data['from']->firstname . ' ' .  $this->data['from']->name,
                    ),
                    $attachment
                );
                $mail->attach($customizedContract);
            }
        }

        return $mail;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function old_toMail($notifiable)
    {
        $subcopy    = null;
        $lang       = strtolower( $this->data['contact']->language  ? $this->data['contact']->language  : 'en' );
        $prox       = $this->data['contact']->proximity ? $this->data['contact']->proximity : 1;
        $prox       = $prox ."_". $lang;
        $name       = $this->data['contact']->firstname;
        $from       = $this->data['from']->firstname;
        $firstname  = explode('@', $this->data['from']->email);
        $signature  = "$firstname[0].txt";
        $signature  = "$firstname[0].png";
        $signature  = "$firstname[0].jpg";
        $view       = $this->data['campaign_template']->image;
        $image      = $view .'.jpg';
        /**
         * public variables in order to pass them to views/markdown
         */
        $this->signature  = $firstname[0];
        $this->image      = $view;

        if ( $prox > 1 ) {
            $name .= " ". $this->data['contact']->name;
            $from .= " ". $this->data['from'   ]->name;
        }

        $mail = new MailjetMessage( $this->data['contact']->id, $this->data['campaign']->id );
        /*
         * A tester pour voir si embed est supporte sans adjonction de librairie
                $mail->withSwiftMessage(function($swiftmessage) use ($image) {
                    $swiftmessage->embed( \Swift_Image::fromPath('image' . $image ));
                });
        */
        if( null == $view ) {
            $mail->markdown('vendor.notifications.email', ['image' => $this->image, 'signature' => $this->signature] );
        } else {
            $mail->markdown('emails.'. $view            , ['image' => $this->image, 'signature' => $this->signature] );
        }

        $mail->from( $this->data['from']->email, $this->data['from']->firstname ." ". $this->data['from']->name );

        $subject = $this->data['campaign_template']->{"subject_$prox"};
        if( $subject ){ $mail->subject($subject); }

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

        return $mail;
    }
}
