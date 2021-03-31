@extends('layouts.default')

@section('content')

    <div x-data="{ openModal: false }">
        <livewire:documents-table
            model="App\Models\Document"
            searchable="name,description,format"
            filterable
            exportable
            beforeTableSlot="documents.before"
            afterTableSlot="documents.after"
        />
    </div>

@endsection
