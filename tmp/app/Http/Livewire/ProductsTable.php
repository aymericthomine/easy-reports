<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ProductsTable extends LivewireDatatable
{
    public $model = Product::class;
    public $isOpen = false;
    public $current;
    public $product_id;
    public $name;
    public $description;
    public $reward;

    public function columns()
    {
        return [
            Column::callback(['id'], function ($id) {
                return view('products.actions', ['id' => $id]);
            }),

            NumberColumn::name('id')->filterable(),

            Column::name('name')->filterable()->searchable()->editable(),

            Column::name('description')->filterable()->searchable()->editable(),

            Column::name('reward')->filterable()->searchable()->editable(),
        ];
    }

    private function resetInputFields()
    {
        $this->resetErrorBag();
        $this->product_id = null;
        $this->name = null;
        $this->description = null;
        $this->reward = null;
    }

    public function openModal()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $this->openModal();
        return view('products.create-or-update');
    }

    public function edit($id)
    {
        $this->current = Product::findOrFail($id);
        $this->openModal();
        $this->product_id = $id;
        $this->name = $this->current->name;
        $this->description = $this->current->description;
        $this->reward = $this->current->reward;
        // return view('products.create-or-update', compact('product'));
    }

    public function store()
    {
        $this->closeModal();
        Product::create(request()->validate(Product::validationRules()));

        return request();
//        return redirect(route('products.index'))->with('success', 'Product created !');
    }

    public function update(Product $product)
    {
        $this->closeModal();
        $product->update(request()->validate(Product::validationRules()));
        return redirect(route('products.index'))->with('success', 'Product updated !');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect(route('products.index'))->with('success', 'Product deleted !');
    }

}
