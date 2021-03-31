@extends('layouts.default')

@section('content')

    <div class="mt-10" x-data="{ openModal: false }">
        <livewire:companies-table
            model="App\Models\Company"
            searchable="name,description,reward"
            filterable
            exportable
            beforeTableSlot="companies.before"
            afterTableSlot="companies.after"
            per-page="100"
        />
    </div>

@endsection
