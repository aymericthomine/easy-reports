@include('includes.head')

<body>
    <div class="p-6 flex flex-col justify-left">
        You have successfully subscribed from our mailing list
    </div>
    <x-jet-button class="ml-4 btn"
                  type="button"
                  wire:click="home()">
        Confirm unsubscription
    </x-jet-button>
</body>
