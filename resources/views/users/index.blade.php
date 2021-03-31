@extends('layouts.default')

@section('content')

    <!-- Integration de Livewire:Datatable avec une Modal d'edition
      -- la Modal utilise Alpine Js pour permettre la gestion des regles de validation
      -- pour cela la Modal ne doit pas etre fermee lors de la validation mais rester ouverte
      -- pour afficher les erreurs
      -- La Modal est donc fermee une fois les regles validee et l'enregistrement effectue
      -- via l'envoi du message depuis la classe du composant Livewire:
      --    $this->dispatchBrowserEvent('user-added');
      -->
    <div class="mt-10" x-data="{ openModal: false }">
        <livewire:users-table
            model="App\Models\User"
            searchable="name,email"
            sortable
            filterable
            exportable
            beforeTableSlot="users.before"
            afterTableSlot="users.after"
            per-page="100"
        />
    </div>
@endsection
