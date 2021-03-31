@extends('layouts.default')

@section('content')

    <div x-data="{ openModal: false }">
        <livewire:prospects-table
            model="App\Models\Prospect"
            searchable="A,B,C,D,E,F,G,H,I,J,K,L,M,N,O"
            filterable
            exportable
            beforeTableSlot="prospects.before"
            afterTableSlot="prospects.after"
            per-page="100"
        />
    </div>

@endsection
