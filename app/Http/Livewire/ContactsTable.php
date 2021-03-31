<?php

namespace App\Http\Livewire;

use App\Models\Campaign;
use App\Models\CampaignTemplate;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\CampaignNotification;
use Faker\Provider\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Stevebauman\Location\Facades\Location;
use function PHPUnit\Framework\isEmpty;


class ContactsTable extends LivewireDatatable
{
    public $model = Contact::class;
    public $contact;
    public $contact_id;
    public $firstname;
    public $name;
    public $subject;
    public $email;
    public $role;
    public $link;
    public $operation;
    public $category;
    public $comments;
    public $email_template_dir = 'views/emails';
    public $email_templates;
    public $campaign_templates;
    public $molitor_emails;
    public $campaign_template;
    public $campaign_template_id;
    public $campaign_template_name;
    public $campaign_id;
    public $campaign_name;
    public $password;
    public $email_status;
    public $URLs = array();
    public $unsubscription = false;
    public $modalAction;
    public $from_id;
    public $from_name;
    public $language;
    public $unsubscribe;
    public $proximity;
    public $from_firstname;
    public $from_email;
    public $progress = 0;

    public function builder()
    {
        return Contact::query()
            ->leftJoin('companies' , 'companies.id' , 'contacts.company_id');
    }

    public function columns()
    {
        return [
            Column::checkbox(),
            Column::callback(['id'], function ($id) { return view('contacts.actions', ['id' => $id]); }),
            Column::name('name')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('firstname')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('gender')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('class')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('comments')->filterable()->searchable()->editable()->defaultSort('asc'),
        ];
    }

    /*
     * Database Actions (SCRUD): Select, Read, Create, Update, Delete
     */
    public function index()
    {
        $this->email_templates      = File::directories(resource_path( $this->email_template_dir ));
        $this->campaign_templates   = CampaignTemplate::all();
        $this->molitor_emails       = User::query()->where('email', 'like', '%@molitor-partners.com');

        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        Contact::create($this->validate(Contact::validationRules()));
        $this->closeModal();
    }

    public function update()
    {
        Log::debug($this->contact);

        $this->contact->update($this->validate(Contact::validationRules()));
        $this->closeModal();
    }

    public function destroy()
    {
        Log::debug($this->contact);
        $this->contact->delete();
        $this->closeModal();
    }

    /*
     * Modal form functions
     */
    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-modal-event');
    }

    static function unsubscribeConfirmation(User $user)
    {
//        return view('users.unsubscribe', compact('user', $this->unsubscription ));
        return view('users.unsubscribe', compact( 'user' ));
    }

    public function unsubscribe()
    {
        DB::table('contacts')->updateWhere(['id' => $id], ['email_status' => 'unsub']);
    }

    public function openModal($action, $id=0)
    {
        $this->modalAction = $action;
        $this->resetErrorBag();

        if( 0 == $id ) {
            $this->contact_id   = null;
            $this->firstname    = null;
            $this->name         = null;
            $this->email        = null;
            $this->role         = null;
            $this->operation    = null;
            $this->category     = null;
            $this->comments     = null;
            $this->password     = Hash::make('molitor123');

        }
        else {
            $this->contact      = Contact::findOrFail($id);
            $this->contact_id   = $id;
            $this->firstname    = $this->contact->firstname;
            $this->name         = $this->contact->name;
            $this->email        = $this->contact->email;
            $this->role         = $this->contact->role;
            $this->operation    = $this->contact->operation;
            $this->category     = $this->contact->category;
            $this->comments     = $this->contact->comments;
            $this->password     = $this->contact->password;
        }

        $this->dispatchBrowserEvent('open-modal-event');
    }

    public function updatedCampaignTemplateId()
    {
        $this->campaign_template    = CampaignTemplate::findOrFail($this->campaign_template_id);
        $this->campaign_name        = $this->campaign_template->name .'_'. date('d-M_H:i');
        // $this->campaign_templates->where($this->campaign_template_id)->get('name') .'_'. date('d-M:H:i');
    }

    public function notify()
    {
        // already fetched in updateTemplateId: $campaign_template = CampaignTemplate::findOrFail($this->campaign_template_id);

        $from       = User::findOrFail($this->from_id);
        $campaign   = Campaign::create([
            'campaign_template_id'  => $this->campaign_template_id,
            'name'                  => $this->campaign_name,
            'email'                 => $from->email,
        ]);

        foreach ($this->selected as $v) {

            $contact    = Contact::findOrFail($v);

            // $unsubscribe  = $contact->email_status;

            $data       = array(
                'contact'               => $contact,
                'from'                  => $from,
                'campaign'              => $campaign,
                'campaign_template'     => $this->campaign_template,
            );

            $contact->notify(new CampaignNotification( $data ));

        }
        $this->closeModal();
    }

    public function updateAll()
    {
        $a = [];

        foreach( ['role','language','proximity','operation','category'] as $attr) {
            if( isset( $this->{$attr} ) && !empty( $this->{$attr} ) ){
                $a = array_merge( [$attr => $this->{$attr}], $a );
            }
        }

        Contact::whereIn('id', $this->selected )->update( $a );
        $this->closeModal();
    }

    public function deleteAll()
    {
        Contact::destroy($this->selected);
        $this->closeModal();
    }

}
