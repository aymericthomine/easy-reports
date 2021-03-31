@extends('layouts.default')

@section('content')

    <div class="mt-10" x-data="{ openModal: false }">
        <livewire:campaign-notifs-table
            model="App\Models\CampaignNotif"
            searchable="email,event,request"
            filterable
            exportable
            beforeTableSlot="campaign-notifs.before"
            afterTableSlot="campaign-notifs.after"
            per-page="100"
        />
    </div>

@endsection
