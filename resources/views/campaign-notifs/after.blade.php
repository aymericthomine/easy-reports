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
                        @method( isset($campaign_notif_id) ? 'PUT' : 'POST' )
                        @csrf

                        @if( $modalAction == 'sendNotif' )

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

                            </div>
                            <div class="modal-footer">
                                <div class="text-right">
                                    <button style="color: #222222"
                                            class="mt-5"
                                            x-on:click="openModal = false">
                                        {{__('Close')}}
                                    </button>
                                    @if( $modalAction != 'readonly' && $modalAction != 'sendNotif' )
                                        <x-jet-button type="button"
                                                      style=" background-color: #fd5f12"
                                                      class="mt-5 ml-6"
                                                      wire:click="{{ $modalAction }}"
                                                      wire:loading.attr="disabled"
                                        >{{__($modalAction)}}
                                        </x-jet-button>
                                    @else
                                        <x-jet-button type="button"
                                                      style=" background-color: #fd5f12"
                                                      class="mt-5 ml-6"
                                                      wire:click="{{ $modalAction }}"
                                                      wire:loading.attr="disabled"
                                        >{{__('Send Notification')}}
                                        </x-jet-button>

                                    @endif
                                </div>
                            </div>
                        @else

                            <div class="form-group flex flex-col mt-2">
                                    <div class="mt-4">
                                        <x-jet-label value="{{ __('Email') }}" />
                                        <x-jet-input type="email" class="block mt-1 w-full" name="email" for="email" id="email" placeholder="Email"
                                                     value="{{ old('email') }}"
                                                     wire:model.lazy="email" />
                                        <x-jet-input-error for="email" class="mt-2" />
                                    </div>
                            </div>

                            <div class="form-group flex flex-col">
                                <div class="mt-4">
                                    <x-jet-label value="{{ __('Event') }}" />
                                    <x-jet-input type="event" class="block mt-1 w-full" name="event" for="event" id="event" placeholder="Event"
                                                 value="{{ old('event') }}"
                                                 wire:model.lazy="event" />
                                    <x-jet-input-error for="event" class="mt-2" />
                                </div>
                            </div>

                            <div class="form-group flex flex-col">
                                <div class="mt-4">
                                    <x-jet-label value="{{ __('Request') }}" />
                                    <x-jet-input type="request" class="block mt-1 w-full" name="request" for="request" id="request" placeholder="HTTP Request"
                                                 value="{{ old('request') }}"
                                                 wire:model.lazy="request" />
                                    <x-jet-input-error for="request" class="mt-2" />
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="text-right">
                                    <button style="color: #22222"
                                            class="mt-5"
                                            x-on:click="openModal = false">
                                        {{__('Close')}}
                                    </button>
                                    @if( $modalAction != 'readonly' )
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
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
