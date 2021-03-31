@extends('layouts.default')

@section('content')

    <div class="mt-10" x-data="{ openModal: false }">
        <livewire:campaign-templates-table
            model="App\Models\CampaignTemplate"
            searchable="name"
            filterable
            exportable
            beforeTableSlot="campaign-templates.before"
            afterTableSlot="campaign-templates.after"
        />
    </div>

@endsection
