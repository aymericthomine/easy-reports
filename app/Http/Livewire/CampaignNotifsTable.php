<?php

namespace App\Http\Livewire;

use App\Models\Campaign;
use App\Models\CampaignNotif;
use App\Models\CampaignTemplate;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\CampaignNotification;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class CampaignNotifsTable extends LivewireDatatable
{
    public $model = CampaignNotif::class;
    public $campaignNotif;
    public $campaign_id;
    public $contact_id;
    public $email;
    public $event;
    public $request;

    public $campaign_template_id;
    public $campaign_template;
    public $campaign_name;
    public $from_id;

    public $modalAction = '';

    public function builder()
    {
        return CampaignNotif::query()
            ->leftJoin('contacts' , 'contacts.id' , 'campaign_notifs.contact_id')
            ->leftJoin('campaigns', 'campaigns.id', 'campaign_notifs.campaign_id');
    }

    public function columns()
    {
        return [
            Column::checkbox(),
            DateColumn::name('updated_at')->format('d M H:i')->label(__('Last event'))->filterable()->defaultSort('desc'),
            DateColumn::name('created_at')->format('d M H:i')->label(__('Created'))->filterable(),
            Column::name('campaigns.name')->label(__('Campaign'))->filterable(),
            Column::name('contacts.name')->label(__('Contact'))->filterable(),
            Column::name('contacts.email')->label(__('Email'))->filterable()->searchable(),
            Column::name('request')->truncate()->filterable()->searchable(),
            Column::name('Sent')->filterable([0,1])->alignCenter(),
            Column::name('Open')->filterable([0,1,2,3,4,5,6,7,8,9])->alignCenter(),
            Column::name('Click')->filterable([0,1,2,3,4,5,6,7,8,9])->alignCenter(),
            Column::name('Bounce')->filterable([0,1])->alignCenter(),
            Column::name('Spam')->filterable([0,1])->alignCenter(),
            Column::name('Blocked')->filterable([0,1])->alignCenter(),
            Column::name('Unsub')->filterable([0,1])->alignCenter(),
        ];
    }

    /*
     * Database Actions (SCRUD): Select, Read, Create, Update, Delete
     */
    public function index()
    {
        $campaignNotif = CampaignNotif::all();
        return view('campaign-notifs.index', compact('campaignNotif'));
    }

    public function create(Request $request)
    {
        CampaignNotif::create($this->validate(CampaignNotif::validationRules()));
        $this->closeModal();
    }

    public function update()
    {
        $this->campaignNotif->update($this->validate(CampaignNotif::validationRules()));
        $this->closeModal();
    }

    public function destroy()
    {
        $this->campaignNotif->delete();
        $this->closeModal();
    }

    /*
     * Modal form functions
     */
    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-modal-event');
    }

    public function openModal($action, $id = 0)
    {
        $this->modalAction = $action;
        $this->resetErrorBag();

        if (0 == $id) {
            $this->event = null;
        } else {
            $this->event = $this->notifStatus->event;
        }

        $this->dispatchBrowserEvent('open-modal-event');
    }

    public function updatedCampaignTemplateId()
    {
        Log::info($this->campaign_template_id);
        $this->campaign_template    = CampaignTemplate::findOrFail($this->campaign_template_id);
        $this->campaign_name        = $this->campaign_template->name .'_'. date('d-M_H:i');
        // $this->campaign_templates->where($this->campaign_template_id)->get('name') .'_'. date('d-M:H:i');
        Log::info($this->campaign_name);
    }

    public function sendNotif()
    {
        // already fetched in updateTemplateId: $campaign_template = CampaignTemplate::findOrFail($this->campaign_template_id);

        $from       = User::findOrFail($this->from_id);
        $campaign   = Campaign::create([
            'campaign_template_id'  => $this->campaign_template_id,
            'name'                  => $this->campaign_name,
            'email'                 => $from->email,
        ]);

        foreach ($this->selected as $v) {
            $current    = CampaignNotif::findOrFail($v);
            $contact    = Contact::findOrFail($current->contact_id);
            $data       = array(
                'contact'           => $contact,
                'from'              => $from,
                'campaign'          => $campaign,
                'campaign_template' => $this->campaign_template,
            );
            $contact->notify(new CampaignNotification($data));
        }
        $this->closeModal();
    }





    /*
     * A SUPPRIMER
     * send email with MailJet and create an entry into the campaign_notifs table
     * the id created will be the customID
     * This customID need to be added to the header in order to
     * make the link with the events received from Mailjet
     */
    public static function send( Mailable $msg, array $data )
    {
        $campaignNotif = CampaignNotif::create( $data );
        $customId = $campaignNotif->id;

        //$msg = new ContactUs($data);
        $msg->withSwiftMessage(function($swiftmessage) use ($customId) {
            $swiftmessage->getHeaders()->addTextHeader('X-MJ-CustomID', $customId );
        });

        // $msg->send();
        \Mail::send( $msg );
    }
}
