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
        <div class="modal-container bg-white w-5/6 md:max-w-2xl mx-auto rounded shadow-lg z-50 overflow-y-auto cursor-auto">
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
                        @method( isset($user_id) ? 'PUT' : 'POST' )
                        @csrf

                    @if( ! isset($user_id) && ! empty($URLs) )
                        <div class="form-group flex flex-col mt-2">
                            <textarea class="w-100 mt-2 py-3 px-3 rounded-lg bg-white dark:bg-gray-800 border border-gray-400 dark:border-gray-700 text-gray-800 font-semibold focus:border-indigo-500 focus:outline-none"
                                      wire:model="URLs" row="20" cols="50">
                            </textarea>
                        </div>
                        <div class="modal-footer">
                        <button class="uppercase modal-close md:w-32 bg-indigo-600 hover:bg-blue-dark text-white font-bold py-3 px-6 rounded-lg mt-3 hover:bg-indigo-500 transition ease-in-out duration-300"
                                style="margin-bottom: 20px; background-color: #fd5f12;"
                                x-on:click="openModal = false"
                        >{{__('Close')}}</button>
                        </div>
                    @else
                        <div class="form-group flex flex-col mt-2">
                            <div class="mt-4">
                                <x-jet-label value="{{ __('Name') }}" />
                                <x-jet-input type="name" class="block mt-1 w-full" name="name" for="name" id="name" placeholder="Full Name"
                                             value="{{ old('name') }}"
                                             wire:model.lazy="name"
                                             action="{{ $modalAction }}"
                                />
                                <x-jet-input-error for="name" class="mt-2" />
                            </div>
                        </div>

                        <div class="form-group flex flex-col">
                            <div class="mt-4">
                                <x-jet-label value="{{ __('Email') }}" />
                                <x-jet-input type="email" class="block mt-1 w-full" name="email" for="email" id="email" placeholder="Email address"
                                             value="{{ old('email') }}"
                                             wire:model.lazy="email"
                                             action="{{ $modalAction }}"
                                />
                                <x-jet-input-error for="email" class="mt-2" />
                            </div>
                        </div>

                        <div class="form-group flex flex-col">
                            <div class="mt-4">
                                <x-jet-label value="{{ __('Role') }}" />
                                <x-jet-input type="role" class="block mt-1 w-full" name="role" for="role" id="role" placeholder="Role"
                                             value="{{ old('role') }}"
                                             wire:model.lazy="role"
                                             action="{{ $modalAction }}"
                                />
                                <x-jet-input-error for="role" class="mt-2" />
                            </div>
                        </div>

                            <div class="modal-footer">
                                <div class="text-right">
                                    <button style="color: #222222"
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
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
