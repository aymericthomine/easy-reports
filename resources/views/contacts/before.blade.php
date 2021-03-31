<!-- ouverture de la Modal realisee au niveau du component qui dispatch l'event suivant
  -- x-on:click="openModal = true"
  -->
<div class="mb-4">

    <x-jet-button class="btn" wire:click="openModal('create')" wire:loading.attr="disabled">
        <img class="mr-3" width="20" src="/images/add-user.png"/>
        {{ __('Add a new Student') }}
    </x-jet-button>

    @if( ! empty($selected) )

        {{-- <x-jet-button class="ml-4 btn" wire:click="mail()" wire:loading.attr="disabled">
            <img class="mr-3" width="20" src="/images/email.png"/>
            {{__('Send an email')}}
        </x-jet-button>

        <x-jet-button class="ml-4 btn" wire:click="sendContract()" wire:loading.attr="disabled">
            <img class="mr-3" width="20" src="/images/contract.png"/>
            {{__('Send the contract')}}
        </x-jet-button>--}}
        <x-jet-button class="ml-4 btn" wire:click="unsubscribe()" wire:loading.attr="disabled">
            <img class="mr-3" width="20" src="/images/reset.png"/>
            {{__('Reset Password')}}
        </x-jet-button>
        <x-jet-button class="ml-4 btn" wire:click="openModal('notify')" wire:loading.attr="disabled">
            <img class="mr-3" width="20" src="/images/notification.png"/>
            {{__('Mailing')}}
        </x-jet-button>
        <x-jet-button class="ml-4 btn" style="background-color: #03cc00; color: white" wire:click="openModal('updateAll')" wire:loading.attr="disabled">
            <img class="mr-3" width="20" src="/images/update.png"/>
            {{__('Update')}}
        </x-jet-button>
        <x-jet-button class="ml-4 btn" style="background-color: #fe2419; color: white" wire:click="openModal('deleteAll')" wire:loading.attr="disabled">
            <img class="mr-3" width="20" src="/images/trash.png"/>
            {{__('Delete')}}
        </x-jet-button>

    @endif
</div>

<style>
    .btn {
        img: url("/images/add-user.png");
        background-color: #75C7FB;
        border: none;
        color: #FFFFFF;
    }

    .btn:hover {
        background-color: #FF3847;
        color: #222222;
    }

    #image:hover {
        image: src("/images/add-user.png");
    }

</style>
