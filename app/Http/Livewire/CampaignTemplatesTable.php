<?php

namespace App\Http\Livewire;

use App\Imports\ProspectsImport;
use App\Models\CampaignTemplate;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Livewire\WithFileUploads;
use Stevebauman\Location\Facades\Location;

use App\Http\Requests;
use Illuminate\Http\Request;

class CampaignTemplatesTable extends LivewireDatatable
{
    use WithFileUploads;

    public $model = CampaignTemplate::class;
    public $campaign_template;
    public $campaign_template_id;
    public $name;
    public $file;
    public $subject_1_fr;
    public $subject_2_fr;
    public $subject_1_en;
    public $subject_2_en;
    public $greetings_1_fr;
    public $greetings_2_fr;
    public $greetings_1_en;
    public $greetings_2_en;
    public $line1_1_fr;
    public $line1_2_fr;
    public $line1_1_en;
    public $line1_2_en;
    public $line2_1_fr;
    public $line2_2_fr;
    public $line2_1_en;
    public $line2_2_en;
    public $salutations_1_fr;
    public $salutations_2_fr;
    public $salutations_1_en;
    public $salutations_2_en;
    public $view_1_fr;
    public $view_2_fr;
    public $view_1_en;
    public $view_2_en;
    public $attachment_fr;
    public $attachment_en;
    public $link;
    public $image;
    public $link_position;
    public $view;
    public $file_fr;
    public $contact;
    public $file_en;
    public $unsubscribe;
    public $linksFiles;
    public $modalAction = '';

    public function columns()
    {
        return [
            Column::callback(['id'], function ($id) {
                return view('campaign-templates.actions', ['id' => $id]);
            }),
            Column::name('name')->filterable()->searchable()->editable(),
            Column::name('subject_1_fr')->filterable()->searchable()->editable(),
            Column::name('subject_2_fr')->filterable()->searchable()->editable(),
            Column::name('subject_1_en')->filterable()->searchable()->editable(),
            Column::name('subject_2_en')->filterable()->searchable()->editable(),
            Column::name('unsubscribe')->filterable()->searchable()->editable(),
        ];
    }

    /*
    * Database Actions (SCRUD): Select, Read, Create, Update, Delete
    */

    public function index()
    {
        $campaignTemplates  = CampaignTemplate::all();
        return view('campaign-templates.index', compact('campaignTemplates'));
    }

    public function create()
    {
        if ($this->file_fr) { $this->file_fr->storeAs('attachments', $this->attachment_fr); }
        if ($this->file_en) { $this->file_en->storeAs('attachments', $this->attachment_en); }

        CampaignTemplate::create($this->validate(CampaignTemplate::validationRules()));
        $this->closeModal();
    }

    public function update()
    {
        if ($this->file_fr) { $this->file_fr->storeAs('attachments', $this->attachment_fr); }
        if ($this->file_en) { $this->file_en->storeAs('attachments', $this->attachment_en); }

        Log::info($this->unsubscribe);

        $this->campaign_template->update($this->validate(CampaignTemplate::validationRules($this->campaign_template_id)));
        $this->closeModal();
    }

    public function duplicate()
    {
        if ($this->file_fr) { $this->file_fr->storeAs('attachments', $this->attachment_fr); }
        if ($this->file_en) { $this->file_en->storeAs('attachments', $this->attachment_en); }

        CampaignTemplate::create($this->validate(CampaignTemplate::validationRules()));
        $this->closeModal();
    }

    public function destroy()
    {
        $this->campaign_template->delete();
        $this->closeModal();
    }

    /*
     * Modal form functions
     */
    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-modal-event');
    }

    /*
    public function updatedName()
    {
        $this->name = $this->validate(CampaignTemplate::validationRules(['name']));
    }
    */

    public function openModal($action, $id = 0)
    {
        $this->modalAction = $action;
        $this->resetErrorBag();

        // $this->linksFiles = File::files(resource_path('views/links'));
        $this->linksFiles = scandir(resource_path('views/links'));

        if (0 == $id) {
            $this->campaign_template_id = null;
            $this->name                 = null;
            $this->attachment_fr        = null;
            $this->attachment_en        = null;
            $this->link                 = null;
            $this->image                = null;
            $this->unsubscribe          = false;

            foreach ( CampaignTemplate::fieldList() as $i ) {
                $this->{$i . "_1_fr"}   = null;
                $this->{$i . "_2_fr"}   = null;
                $this->{$i . "_1_en"}   = null;
                $this->{$i . "_2_en"}   = null;
            }
        } else {
            $this->campaign_template    = CampaignTemplate::findOrFail($id);
            $this->campaign_template_id = $this->campaign_template->id;
            $this->name                 = $this->campaign_template->name;
            $this->attachment_fr        = $this->campaign_template->attachment_fr;
            $this->attachment_en        = $this->campaign_template->attachment_en;
            $this->link                 = $this->campaign_template->link;
            $this->image                = $this->campaign_template->image;
            $this->unsubscribe          = $this->campaign_template->unsubscribe;

            foreach ( CampaignTemplate::fieldList() as $i ) {
                $this->{$i ."_1_fr"}    = $this->campaign_template->{$i ."_1_fr"};
                $this->{$i ."_2_fr"}    = $this->campaign_template->{$i ."_2_fr"};
                $this->{$i ."_1_en"}    = $this->campaign_template->{$i ."_1_en"};
                $this->{$i ."_2_en"}    = $this->campaign_template->{$i ."_2_en"};
            }

            if ('duplicate' == $this->modalAction) $this->name .= "_copy";
        }

        $this->dispatchBrowserEvent('open-modal-event');
    }

    public function dragAndDrop(Request $request)
    {
        Log::debug($request->file('file'));

        return response()->json(['success'=> $request->file('file')->getClientOriginalName() ]);
    }

    public function updatedFileFr()
    {
        $this->validate([ 'file_fr' => 'required|mimes:doc,docx|max:1024000', ]);

        $path = storage_path('framework/cache/facade-c2f53e2d655810ac111b48d42b34b209861bb985.php');

        Log::debug(env('APP_STORAGE', base_path() . '/storage') );
        Log::debug('$path: ' . $path );

        $this->attachment_fr = $this->file_fr->getClientOriginalName();
        Log::info('updatedFileFr out: '. $this->attachment_fr);
    }

    public function updatedFileEn()
    {
        $this->validate([ 'file_en' => 'required|mimes:doc,docx|max:1024000', ]);
        $this->attachment_en = $this->file_en->getClientOriginalName();
    }

    public function preFill()
    {
        foreach ( CampaignTemplate::fieldList() as $i ) {
            if( ! $this->{$i ."_2_fr"} ) $this->{$i ."_2_fr"} = $this->{$i ."_1_fr"};
            if( ! $this->{$i ."_2_en"} ) $this->{$i ."_2_en"} = $this->{$i ."_1_en"};
        }
    }

    public function preTranslate()
    {
        foreach ( CampaignTemplate::fieldList() as $i ) {
            if( ! $this->{$i ."_1_en"} && $this->{$i ."_1_fr"} ) $this->{$i ."_1_en"} = GoogleTranslate::trans( $this->{$i ."_1_fr"} );
            if( ! $this->{$i ."_2_en"} && $this->{$i ."_2_fr"} ) $this->{$i ."_2_en"} = GoogleTranslate::trans( $this->{$i ."_2_fr"} );
        }
    }
}
