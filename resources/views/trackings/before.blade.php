<!-- ouverture de la Modal realisee au niveau du component qui dispatch l'event suivant
  -- x-on:click="openModal = true"
  -->
<div class="mb-4">

    @if( ! empty($selected) )
        <x-jet-button class="ml-4 btn" style="background-color: #fe2419; color: white" wire:click="openModal('deleteAll')" wire:loading.attr="disabled">
            <img class="mr-3" width="20" src="/images/trash.png"/>
            {{__('Delete')}}
        </x-jet-button>
    @endif

</div>

<style>
    .btn {
        img: url("/images/add-user.png");
        background-color: #ffecdc;
        border: none;
        color: #222222;
    }

    .btn:hover {
        background-color: #fd5f12;
        color: white;
    }

    #image:hover {
        image: src("/images/add-user.png");
    }

</style>

