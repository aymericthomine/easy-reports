<!-- ouverture de la Modal realisee au niveau du component qui dispatch l'event suivant
  -- x-on:click="openModal = true"
  -->
<div class="mb-4">

    <form style="margin-top: 40px; width: auto; height: 10px; border-radius: 5px;" action="{{ route('prospects.drop') }}" method="POST" enctype="multipart/form-data" class="dropzone" id='image-upload'>
        @csrf
    </form>

    @if( ! empty($selected) )
        <x-jet-button class="mt-4 ml-4 btn" wire:click="toContact()" wire:loading.attr="disabled">
            <img class="mr-3" width="20" src="/images/add-user.png"/>
            {{__('TRANSFER TO CONTACT')}}
        </x-jet-button>

        <x-jet-button class="mt-4 ml-4 btn" style="background-color: #03cc00; color: white" wire:click="openModal('updateAll')" wire:loading.attr="disabled">
            <img class="mr-3" width="20" src="/images/update.png"/>
            {{__('Update')}}
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
