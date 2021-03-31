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
        <div style="margin: auto;" class="modal-container bg-white w-5/6 md:max-w-2xl mx-auto rounded shadow-lg z-50 cursor-auto">
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
                        @method( isset($prospect_id) ? 'PUT' : 'POST' )
                        @csrf

                        @if($modalAction == 'updateAll')
                        <div class="form-group flex flex-col">
                            <div class="mt-4">
                                <x-jet-label value="{{ __('Role') }}" />
                                <x-jet-input type="A" class="block mt-1 w-full" name="role" for="A" id="A" placeholder="Enter role"
                                             value="{{ old('role') }}"
                                             wire:model.lazy="role"
                                             action="{{ $modalAction }}"
                                />
                                <x-jet-input-error for="A" class="mt-2" />
                            </div>
                        </div>

                        <div class="form-group flex flex-col">
                            <div class="mt-4">
                                <x-jet-label value="{{ __('Category') }}" />
                                <x-jet-input type="E" class="block mt-1 w-full" name="category" for="E" id="E" placeholder="Enter category"
                                             value="{{ old('category') }}"
                                             wire:model.lazy="category"
                                             action="{{ $modalAction }}"
                                />
                                <x-jet-input-error for="E" class="mt-2" />
                            </div>
                        </div>

                        <div class="form-group flex flex-col">
                            <div class="mt-4">
                                <x-jet-label value="{{ __('Language') }}" />
                                <x-jet-input type="C" class="block mt-1 w-full" name="lang" for="C" id="C" placeholder="Enter language"
                                             value="{{ old('lang') }}"
                                             wire:model.lazy="lang"
                                             action="{{ $modalAction }}"
                                />
                                <x-jet-input-error for="C" class="mt-2" />
                            </div>
                        </div>

                        <div class="form-group flex flex-col">
                            <div class="mt-4">
                                <x-jet-label value="{{ __('Operation') }}" />
                                <x-jet-input type="O" class="block mt-1 w-full" name="operation" for="O" id="O" placeholder="Enter operation"
                                             value="{{ old('operation') }}"
                                             wire:model.lazy="operation"
                                             action="{{ $modalAction }}"
                                />
                                <x-jet-input-error for="O" class="mt-2" />
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="text-right">
                                <button style="color: #222222"
                                        class="mt-5"
                                        x-on:click="openModal = false">
                                    {{__('Close')}}
                                </button>
                                @if( $modalAction != 'updateAll')
                                    <x-jet-button type="button"
                                                  style=" background-color: #fd5f12"
                                                  class="mt-5 ml-6"
                                                  wire:click="{{ $modalAction }}">
                                        {{__($modalAction)}}
                                    </x-jet-button>
                                @else
                                    <x-jet-button type="button"
                                                  style=" background-color: #03cc00"
                                                  class="mt-5 ml-6"
                                                  wire:click="{{ $modalAction }}">
                                        Update
                                    </x-jet-button>
                                @endif
                            </div>
                        </div>

                        @else
                            <div class="form-group flex flex-col">
                                <div class="mt-4">
                                    <p type="text"
                                       style=" color: #222222"
                                       class="mt-5 ml-6">
                                        {{ $report }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-10 form-group flex flex-col overflow-y-auto mb-4">
                                <div>
                                    <pre style="height: 265px;" type="text" class="ml-6">{{ $emailList }}</pre>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="text-right">
                                    <button style="color: #222222"
                                            class="mt-5"
                                            x-on:click="openModal = false">
                                        {{__('Close')}}
                                    </button>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
