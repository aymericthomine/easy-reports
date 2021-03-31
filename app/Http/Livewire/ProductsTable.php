<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ProductsTable extends LivewireDatatable
{
    public $model = Product::class;
    public Product $product;
    public $product_id;
    public $modalAction = '';
    /**
     * variables utilisées dans after.blade
     * wire:model
     */
    public $name;
    public $description;
    public $reward;


    /**
     * Needed for Binding directly to Model properties
     * https://laravel-livewire.com/docs/2.x/properties
     * retrieved from Model in columns method below
     */
    public $rules;

    public function columns()
    {
        $this->rules = Product::validationRules();

        return [
            Column::callback(['id'], function ($id) { return view('products.actions', ['id' => $id]); }),
            Column::name('name'         )->filterable()->searchable()->editable(),
            Column::name('description'  )->filterable()->searchable()->editable(),
            Column::name('reward'       )->filterable()->searchable()->editable(),
        ];
    }

    /*
     * Database Actions (SCRUD): Select, Read, Create, Update, Delete
     */
    public function updated($field)
    {
        $this->validate(Product::validationRules());
    }

    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        Product::create($this->validate(Product::validationRules()));
        $this->closeModal();
    }

    public function update()
    {
        $this->product->update($this->validate(Product::validationRules($this->product->id)));
        $this->closeModal();
    }

    public function destroy()
    {
        $this->product->delete();
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
            $this->product      = Product::class;
            /*
            $this->product_id   = null;
            $this->name         = null;
            $this->description  = null;
            $this->reward       = null;
            */
        }
        else {
            $this->product      = Product::findOrFail($id);
            /*
             *
            $this->product_id   = $id;
            $this->name         = $this->product->name;
            $this->description  = $this->product->description;
            $this->reward       = $this->product->reward;
            */
        }

        $this->dispatchBrowserEvent('open-modal-event');
    }
}
