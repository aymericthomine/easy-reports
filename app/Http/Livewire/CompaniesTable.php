<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Illuminate\Support\Facades\Http;
use App\Http\Requests;

class CompaniesTable extends LivewireDatatable
{
    public $model = Company::class;
    public $company;
    public $company_id;
    public $name;
    public $siret;
    public $iban;
    public $modalAction = '';

    public function columns()
    {
        return [
            Column::checkbox(),
            Column::callback(['id'], function ($id) { return view('companies.actions', ['id' => $id]); }),
            Column::name('name')->filterable()->searchable()->editable(),
            Column::name('siret')->filterable()->searchable()->editable(),
            Column::name('iban')->filterable()->searchable()->editable(),
        ];
    }

    /*
     * Database Actions (SCRUD): Select, Read, Create, Update, Delete
     */
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        $response_siret = Http::get('https://entreprise.data.gouv.fr/api/sirene/v3/etablissements/' . $this->siret);

        $response_iban = Http::get('https://openiban.com/validate/' . $this->iban);

        if ($response_siret->getStatusCode() == 200 && $response_iban->getStatusCode() == 200) {
            Company::create($this->validate(Company::validationRules()));
            $this->closeModal();
        }
    }

    public function update()
    {
        $this->company->update($this->validate(Company::validationRules()));
        $this->closeModal();
    }

    public function destroy()
    {
        $this->company->delete();
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
            $this->company_id   = null;
            $this->name         = null;
            $this->siret        = null;
            $this->iban         = null;
        }
        else {
            $this->company      = Company::findOrFail($id);
            $this->company_id   = $id;
            $this->name         = $this->company->name;
            $this->siret        = $this->company->siret;
            $this->iban         = $this->company->iban;
        }

        $this->dispatchBrowserEvent('open-modal-event');
    }
}
