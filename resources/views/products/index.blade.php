@extends('layouts.default')

@section('content')

    <div class="mt-10" x-data="{ openModal: false }">
        <livewire:products-table
            model="App\Models\Product"
            searchable="name,description,reward"
            filterable
            exportable
            beforeTableSlot="products.before"
            afterTableSlot="products.after"
        />
    </div>

@endsection
