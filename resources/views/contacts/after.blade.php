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

                <script>
                    function mySpinner() {
                        var element = document.getElementById("loading");
                        element.classList.add("loading-content");
                    }
                    function mySpinnerStop() {
                        var element = document.getElementById("loading");
                        element.classList.remove("loading-content");
                    }
                </script>

                <style>
                    .loading-content {
                        border: 5px solid #f3f3f3;
                        border-top: 5px solid #fd6011;
                        border-radius: 50%;
                        width: 30px;
                        height: 30px;
                        animation: spin 2s linear infinite;
                    }

                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                </style>

                <div class="modal-body">

                    <form wire:submit.prevent="closeModal()" style="padding-left: 30px; padding-right: 30px; padding-bottom: 30px;" class="flex flex-col justify-center">
                        @method( isset($contact_id) ? 'PUT' : 'POST' )
                        @csrf

                        @if( $modalAction == 'notify' )

                            <div class="form-group flex flex-col">

                                <x-jet-label class="mt-10" value="{{ __('Select a template') }}" style="width: 200px;" />

                                <select class="mt-2" id="campaign_template_id" wire:model="campaign_template_id">
                                    <option value="0">{{ __('--- Please Select ---') }}</option>
                                    @foreach( \App\Models\CampaignTemplate::get() as $t )
                                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                                    @endforeach
                                </select>

                                <!-- {  { $campaign_templates->id == $campaign_template_id ? 'selected="selected"' : '' }   } -->

                                <x-jet-label value="{{ __('Mail from address') }}" style="width: 200px;" class="mt-5" />

                                <select class="mt-2" id="from_id" wire:model="from_id">
                                    <option value="0">{{ __('--- Please Select ---') }}</option>
                                    @foreach( \App\Models\User::query()->where('email', 'like', '%@molitor-partners.com')->orWhere('email', 'like', '%@lapalmepartners.fr')->get() as $u )
                                        <option value="{{ $u->id }}">{{ $u->email }}</option>
                                    @endforeach
                                </select>

                                <div class="form-group flex flex-col w-full">
                                    <div class="mt-4">
                                        <x-jet-label value="{{ __('Name of the campaign') }}" />
                                        <x-jet-input type="campaign_name" class="block mt-1 w-full" name="campaign_name" for="campaign_name" id="campaign_name" placeholder="Enter the name"
                                                     value="{{ old('campaign_name') }}"
                                                     wire:model.lazy="campaign_name" />
                                        <x-jet-input-error for="campaign_name" class="mt-2" />
                                    </div>
                                </div>

                                <!-- pro
                                -->

                            </div>
                            <div class="modal-footer" >
                                <div class="text-right">
                                    <button id="loading" class="mr-5"></button>
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
                                                      onclick="mySpinner()"
                                                      wire:loading.attr="disabled" >
                                            {{__($modalAction)}}
                                        </x-jet-button>
                                    @endif
                                </div>
                            </div>
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
                        @elseif($modalAction == 'updateAll')
                            <div class="form-group flex flex-col">
                                <div class="mt-4">
                                    <x-jet-label value="{{ __('Language') }}" />
                                    <x-jet-input type="language" class="block mt-1 w-full" name="language" for="language" id="language" placeholder="Enter language"
                                                 value="{{ old('language') }}"
                                                 wire:model.lazy="language"
                                                 action="{{ $modalAction }}"
                                    />
                                    <x-jet-input-error for="language" class="mt-2" />
                                </div>
                            </div>

                            <div class="form-group flex flex-col">
                                <div class="mt-4">
                                    <x-jet-label value="{{ __('Proximity') }}" />
                                    <x-jet-input type="proximity" class="block mt-1 w-full" name="proximity" for="proximity" id="proximity" placeholder="Enter proximity"
                                                 value="{{ old('proximity') }}"
                                                 wire:model.lazy="proximity"
                                                 action="{{ $modalAction }}"
                                    />
                                    <x-jet-input-error for="language" class="mt-2" />
                                </div>
                            </div>

                            <div class="form-group flex flex-col">
                                <div class="mt-4">
                                    <x-jet-label value="{{ __('Operation') }}" />
                                    <x-jet-input type="operation" class="block mt-1 w-full" name="operation" for="operation" id="operation" placeholder="Enter operation"
                                                 value="{{ old('operation') }}"
                                                 wire:model.lazy="operation"
                                                 action="{{ $modalAction }}"
                                    />
                                    <x-jet-input-error for="language" class="mt-2" />
                                </div>
                            </div>

                            <div class="form-group flex flex-col">
                                <div class="mt-4">
                                    <x-jet-label value="{{ __('Category') }}" />
                                    <x-jet-input type="category" class="block mt-1 w-full" name="category" for="category" id="category" placeholder="Enter category"
                                                 value="{{ old('category') }}"
                                                 wire:model.lazy="category"
                                                 action="{{ $modalAction }}"
                                    />
                                    <x-jet-input-error for="language" class="mt-2" />
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="text-right">
                                    <button style="color: #22222"
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
