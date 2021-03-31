<?php

namespace App\Http\Livewire;

use App\Imports\ProspectsImport;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use \Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;
use PhpParser\Node\Stmt\Continue_;

class ProspectsTable extends LivewireDatatable
{
    use WithFileUploads;

    public $model = Prospect::class;
    public $prospect;
    public $contact;
    public $prospect_id;
    public $name;
    public $firstname;
    public $phone;
    public $country;
    public $lang;
    public $role;
    public $proximity;
    public $email;
    public $category;
    public $company_name;
    public $company_id;
    public $description;
    public $readonly = '';
    public $modalAction;
    public $temp;
    public $report;
    public $emailList;
    public $err;
    public $total;

    public function columns()
    {
        return [
            Column::checkbox(),
            Column::name('A')->label(__('A'))->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('B')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('C')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('D')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('E')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('F')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('G')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('H')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('I')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('J')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('K')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('L')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('M')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('N')->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('O')->filterable()->searchable()->editable()->defaultSort('asc'),
        ];
    }

    /*
 * Database Actions (SCRUD): Select, Read, Create, Update, Delete
 */
    public function index()
    {
        $prospects = Prospect::all();
        return view('prospects.index', compact('prospects'));
    }

    public function create()
    {
        $this->file->store('upload');
        $this->file = base64_encode(file_get_contents($this->file->getRealPath()));

        Prospect::create($this->validate(Prospect::validationRules()));
        $this->closeModal();
    }

    public function toContact()
    {
        $total = 0;
        $err = 0;

        foreach ($this->selected as $id) {

            $this->prospect = Prospect::findOrFail($id);

            try {
                $total++;

                $this->company_id = Company::updateOrcreate([
                    'name'          => $this->prospect->F,
                ])->id;

                $this->contact = Contact::create([
                    'name'          => Str::upper($this->prospect->A),
                    'firstname'     => Str::title($this->prospect->B),
                    'gender'        => $this->prospect->C,
                ]);
            } catch (\Throwable $e) {
                $this->emailList .= 'Name => ' . $this->prospect->A . ', Firstname => ' . $this->prospect->B . ', Gender => ' . $this->prospect->C;
                $err++;
            }
        }

        $this->report = __("Empty/duplicate emails :err on :total", ['err'=>$err, 'total'=>$total]);

        $this->openModal('readonly');
    }

    public function update()
    {
        $this->file->store('upload');
        $this->file = base64_encode(file_get_contents($this->file->getRealPath()));

        $this->prospect->update($this->validate(Prospect::validationRules()));
        $this->closeModal();
    }

    public function destroy()
    {
        $this->prospect->delete();
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
            $this->prospect_id  = null;
            $this->name         = null;
            $this->company_id   = null;
            $this->description  = null;
            $this->format       = null;
            $this->version      = null;
            $this->file         = null;
        }
        else {
            $this->prospect     = Prospect::findOrFail($id);
            $this->prospect_id  = $id;
            $this->name         = $this->prospect->name;
            $this->company_id   = $this->prospect->company_id;
            $this->description  = $this->prospect->description;
            $this->format       = $this->prospect->format;
            $this->version      = $this->prospect->version;
            $this->file         = $this->prospect->file;
        }

        $this->dispatchBrowserEvent('open-modal-event');
    }

    public function updatedFile()
    {
        $this->validate([
            //    'file' => 'required|mimes:xls,xlx|max:1024000',
        ]);
    }

    public function dragAndDrop(Request $request)
    {
        DB::table('prospects')->truncate();
        Log::debug($request->file('file'));
        \Excel::import( new ProspectsImport(), $request->file('file') );

        return response()->json(['success'=> $request->file('file')->getClientOriginalName() ]);
    }

    public function updateAll()
    {
        $a = [];

        foreach ($this->selected as $id) {
            $this->prospect = Prospect::findOrFail($id);

            Log::info($a);

            $a = Contact::updateOrcreate([
                'role' => $this->prospect->A,
            ])->id;

            foreach (['A'] as $attr) {
                if (isset($this->{$attr}) && !empty($this->{$attr})) {
                    $a = array_merge([$attr => $this->{$attr}], $a);
                    Log::info($a);
                }
            }

            Prospect::whereIn('id', $this->selected)->update($a);
            $this->closeModal();
        }
    }

}

