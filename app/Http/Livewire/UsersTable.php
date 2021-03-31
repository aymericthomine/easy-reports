<?php

namespace App\Http\Livewire;

use App\Models\CampaignNotif;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class UsersTable extends LivewireDatatable
{
    public $model = User::class;
    public $user;
    public $user_id;
    public $firstname;
    public $name;
    public $email;
    public $role;
    public $password;
    public $URLs = array();
    public $unsubscription = false;
    public $modalAction;

    public function columns()
    {
        return [
            Column::checkbox(),
            Column::callback(['id'], function ($id) { return view('users.actions', ['id' => $id]); }),
            Column::name('name')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('firstname')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('email')->filterable()->searchable()->defaultSort('asc'),
            Column::name('role')->filterable()->searchable(),
        ];
    }

    /*
     * Database Actions (SCRUD): Select, Read, Create, Update, Delete
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        User::create($this->validate(User::validationRules()));
        $this->closeModal();
    }

    public function update()
    {
        $this->user->update($this->validate(User::validationRules()));
        $this->closeModal();
    }

    public function destroy()
    {
        $this->user->delete();
        $this->closeModal();
    }

    /*
     * Modal form functions
     */
    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-modal-event');
    }

    public function openModal($action, $id=0)
    {
        $this->modalAction = $action;
        $this->resetErrorBag();

        if( 0 == $id ) {
            $this->user_id      = null;
            $this->name         = null;
            $this->email        = null;
            $this->role         = null;
            $this->password     = Hash::make('molitor123');
        }
        else {
            $this->user         = User::findOrFail($id);
            $this->user_id      = $id;
            $this->firstname    = $this->user->firstname;
            $this->name         = $this->user->name;
            $this->email        = $this->user->email;
            $this->role         = $this->user->role;
            $this->password     = $this->user->password;
        }

        $this->dispatchBrowserEvent('open-modal-event');
    }

    public function mail(User $user)
    {
        $this->URLs = array();

        foreach ($this->selected as $v)
        {
            $url = URL::signedRoute('users.unsubscribe', ['user' => $v]);
            array_push($this->URLs, $url );

            $to_name = 'Manuel Dubosc';
            $to_email = 'manuel@dubosc.fr';
            $data = array('name' => 'Molitor Partners', 'url' => "$url");

            Mail::send('emails.test', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name);
                $message->subject('molitor partners');
                $message->from( config('mail.from.address'), config('mail.from.name') );
            });
        }

        return $this->openModal('mail');
    }

    static function unsubscribe(User $user)
    {
//        return view('users.unsubscribe', compact('user', $this->unsubscription ));
        return view('users.unsubscribe', compact( 'user' ));
    }

    static function subscribe(User $user)
    {
        DB::table('contacts')
            ->where('id', $user->id)
            ->update(['email_status' => '']);

        return view('users.subscribe', compact( 'user' ));
    }

    static function home()
    {
        return view('public');
    }


    static function confirm(User $user)
    {
        $unsubscription = true;
        return view('users.unsubscribe')->with('unsubscription',$unsubscription );
    }

    public function sendResetLinkEmail(User $user)
    {
        foreach ($this->selected as $v)
        {
            $user=User::findOrFail($v);
            $token = Password::getRepository()->create($user);
            array_push($this->URLs, $user->email );
            $user->sendPasswordResetNotification($token);
        }

        return $this->openModal('mail');
    }

    public function sendContract()
    {
        $this->URLs = array();
        $contracts = new CustomizedDocuments;

        $mp = User::where('name', 'Molitor Partners')->first();
        $mpInfos = array(
        );

        foreach ($this->selected as $v)
        {
            $user = User::findOrFail($v);

            $url = URL::signedRoute('users.unsubscribe', ['user' => $v]);
            array_push($this->URLs, $url );

            $customizedContract = $contracts->customizeCMContract(
                array(
                    /* Concil Member */
                    'member_societe'    => $user->name,
                    'member_legal'      => $user->name,
                    'member_capital'    => '1000',
                    'member_rcs'        => '08979998',
                    'member_email'      => $user->email,
                    'member_siege'      => 'Paris',

                    /* MOLITOR */
                    'societe'           => $mp->name,
                    'legal'             => $mp->name,
                    'siege'             => 'Boulogne Billancourt',
                    'capital'           => '100 000',
                    'rcs'               => '045449998',
                    'email'             => $mp->email,

                    'date'              => '19/11/2020',
                )
            );

            $to_name = $user->name;
            $to_email = $user->email;
            //$to_email = 'emilien.simoes@expertin.fr';
            $data = array('name' => 'Molitor Partners', 'url' => "$url");

            Mail::send('emails.test', $data, function($message) use ($to_name, $to_email, $customizedContract) {
                $message->to( $to_email, $to_name);
                $message->subject( 'molitor partners' );
                $message->from( config('mail.from.address'), config('mail.from.name') );
                $message->attach( $customizedContract );
            });
        }

        return $this->openModal('mail');
    }

}
