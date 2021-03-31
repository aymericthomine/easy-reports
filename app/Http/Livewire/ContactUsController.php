<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignNotif;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;

class ContactUsController extends Controller
{
    function index()
    {
        return view('contact-us.index');
    }

    function send(Request $request)
    {
        $request->validate([
                            'firstname'             => 'required',
                            'name'                  => 'required',
                            'email'                 => 'required|email|unique:contacts',
                            'phone'                 => 'required',
                            //'full_number'         => 'phone:FR, US,GB,BE,LU',
                            'message'               => 'required',
                            //'checkbox'              => 'required',
                        ]);

        $user = array(
                            'firstname'     => $request->firstname,
                            'name'          => $request->name,
                            'email'         => $request->email,
                            'phone'         => $request->full_number,
                            'role'          => 'Guest',
                            'status'        => 'ContactUs',
                            'proximity'     => 2,
                            'date_rgpd'     => date('Y-m-d'),
                        );

        Log::debug('0');

        $contact  = Contact::create( $user );
        $campaign = Campaign::firstOrCreate([   'name'      =>  'ContactUs' ],
                                            [
                                                'email'     => config('mail.from.address'),
                                                'subject'   => 'Centralise les notifications Mailjet pour les mail de demande de contact WEB',
                                            ]);

        $data = array(
                            'contact'       => $contact,
                            'campaign'      => $campaign,
                            'firstname'     => $request->firstname,
                            'name'          => $request->name,
                            'email'         => $request->email,
                            'phone'         => $request->number,
                            'full_number'   => $request->full_number,
                            'message'       => $request->message,
                            'request'       => 'New contact: ' . $request->email,
                        );

        Log::debug('1');

        $msg = new ContactUs( $data );
        \Mail::send( $msg );
// $msg->send();
        Log::debug('2');

        return view('contact-us.index')->with('success', 'true');
    }
}



