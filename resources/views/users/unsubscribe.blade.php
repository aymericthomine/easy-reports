@include('includes.head')

<body>
    <div class="p-6 flex flex-col justify-left">
        You have successfully unsubscribed from our mailing list
    </div>
    <x-jet-button class="ml-4 btn"
                  type="button"
                  wire:click="subscribe()">
        Confirm subscription
    </x-jet-button>
</body>
