@extends('layouts.default')

@section('content')

    <div class="mt-10" x-data="{ openModal: false }">
        <livewire:trackings-table
            model="App\Models\Tracking"
            searchable="ip,user_agent,ip_user,country"
            filterable
            exportable
            beforeTableSlot="trackings.before"
            afterTableSlot="trackings.after"
            per-page="100"
        />
    </div>

@endsection
