@extends('layouts.default')

@section('content')

    <div class="mt-10" x-data="{ openModal: false }">
        <livewire:campaigns-table
            model="App\Models\Campaign"
            searchable="name"
            filterable
            exportable
            beforeTableSlot="campaigns.before"
            afterTableSlot="campaigns.after"
        />
    </div>

@endsection
