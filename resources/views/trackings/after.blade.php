<!-- Modal -->
<div x-show="openModal"
     x-on:close-modal-event.window="openModal = false"
     x-on:open-modal-event.window="openModal = true"
>
    <!--<div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center">
    -->
    <div class="main-modal fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster"
         style="background: rgba(0,0,0,.8);">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"
             x-on:click="openModal = true">
        </div>
        <div style="margin: auto" class="modal-container bg-white w-5/6 md:max-w-2xl mx-auto rounded shadow-lg z-50 overflow-y-auto cursor-auto">
            <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
            </div>

            <div>
                <div class="sm:mx-auto sm:w-full sm:max-w-md">
                    <h2 class="mt-10 text-3xl font-bold text-center">
                        {{__(Str::title($modalAction))}}
                    </h2>
                </div>

                <div class="modal-body">

                    <form wire:submit.prevent="closeModal()" style="padding-left: 30px; padding-right: 30px; padding-bottom: 30px;" class="flex flex-col justify-center">
                        @method( isset($trackings_id) ? 'PUT' : 'POST' )
                        @csrf

                        <div class="modal-footer">
                            <div class="text-right">
                                <button style="color: #22222"
                                        class="mt-5"
                                        x-on:click="openModal = false">
                                    {{__('Close')}}
                                </button>
                                @if( $modalAction != 'view' )
                                    <x-jet-button type="button"
                                                  style=" background-color: #fd5f12"
                                                  class="mt-5 ml-6"
                                                  wire:click="{{ $modalAction }}"
                                                  wire:loading.attr="disabled"
                                    >{{__($modalAction)}}
                                    </x-jet-button>
                                @elseif($modalAction == 'deleteAll')
                                    <h1 class="mt-5 text-center">Are you sure you want to delete the selected contact(s)?</h1>
                                    <h2 class="mt-2 text-center italic">This action is irreversible..</h2>
                                    <div class="modal-footer">
                                        <div class="text-right">
                                            <button style="color: #22222"
                                                    class="mt-5"
                                                    x-on:click="openModal = false">
                                                {{__('Close')}}
                                            </button>
                                            @if( $modalAction != 'deleteAll')
                                                <x-jet-button type="button"
                                                              style=" background-color: #fd5f12"
                                                              class="mt-5 ml-6"
                                                              wire:click="{{ $modalAction }}">
                                                    {{__($modalAction)}}
                                                </x-jet-button>
                                            @else
                                                <x-jet-button type="button"
                                                              style=" background-color: #fe2419"
                                                              class="mt-5 ml-6"
                                                              wire:click="{{ $modalAction }}">
                                                    CONFIRM
                                                </x-jet-button>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
