<!-- ouverture de la Modal realisee au niveau du component qui dispatch l'event suivant
  -- x-on:click="openModal = true"
  -->
<div class="mb-4">

    <form style="margin-top: 40px; margin-bottom 5px; width: auto; height: 10px; border-radius: 5px;" action="{{ route('documents.drop') }}" method="POST" enctype="multipart/form-data" class="dropzone" id='image-upload'>
        @csrf
    </form>

    <div class="mb-4">

        <x-jet-button class="btn mt-4" wire:click="openModal('create')" wire:loading.attr="disabled">
            <img class="mr-3" width="20" src="/images/add-user.png"/>
            {{__('Add a new Document')}}
        </x-jet-button>

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
</div>
