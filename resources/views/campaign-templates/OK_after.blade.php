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
        <div style="margin: auto" class="modal-container bg-white w-full h-full mx-auto rounded shadow-lg z-50 overflow-y-auto cursor-auto">
            <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
            </div>

            <div>
                <div>

                    <script>
                        function SwapDivsWithClick(div1,div2)
                        {
                            d1 = document.getElementById(div1);
                            d2 = document.getElementById(div2);
                            if( d2.style.display == "none" )
                            {
                                d1.style.display = "none";
                                d2.style.display = "flex";
                            }
                            else
                            {
                                d1.style.display = "flex";
                                d2.style.display = "none";
                            }
                        }
                    </script>

                </div>

            </div>


            <form style="padding-left: 60px; padding-right: 60px; padding-bottom: 20px;" class="flex flex-col justify-center">
                @method( isset($campaign_template_id) ? 'PUT' : 'POST' )
                @csrf

                <h2 class="text-3xl font-bold mt-5 text-center">
                    @if( $modalAction != 'readonly' && $modalAction != 'duplicate' )
                        {{ isset($campaign_template_id) ? __('Update') : __('Create') }}
                    @else
                        {{ isset($campaign_template_id) ? __('Update') : __('Duplicate') }}
                    @endif
                </h2>

                <div id="swapper-first" style="display:flex;" class="form-group flex-col w-full" wire:ignore>

                    <x-jet-label value="{{ __('Nom du template') }}"/>
                    <div class="flex">
                        <div class="form-group flex flex-col">
                            <x-jet-input type="name" class="block mt-1" style="width: 300px;" name="name" for="name" id="name" placeholder="Entrer le nom"
                                         value="{{ old('name') }}"
                                         wire:model="name" />
                            <x-jet-input-error for="name" class="mt-2" />
                        </div>
                        <a href="javascript:SwapDivsWithClick('swapper-first','swapper-other')">
                            <img class="ml-5" width="50" src="/images/france.png">
                        </a>
                    </div>

                    <x-jet-label class="mt-1" value="{{ __('Sujet du mail (fr)') }}"/>
                    <x-jet-input type="text" class="block mt-1 w-full" name="subject_1_fr" id="subject_1_fr" placeholder="Entrer le sujet"
                                 value="{{ old('subject_1_fr') }}"
                                 wire:model.lazy="subject_1_fr" />
                    <x-jet-input-error for="subject_1_fr" class="mt-2" />

                    <x-jet-label class="mt-2" value="{{ __('Formules de salutation (fr)') }}"/>

                    <div style="display: flex">

                        <x-jet-input type="text" class="block mt-1 mr-5 w-full" name="greetings_1_fr" id="greetings_1_fr" placeholder="Prox. 1"
                                     value="{{ old('greetings_1_fr') }}"
                                     wire:model.lazy="greetings_1_fr" />
                        <x-jet-input-error for="greetings_1_fr" class="mt-2" />
                        <x-jet-input type="text" class="block mt-1 w-full" name="greetings_2_fr" id="greetings_2_fr" placeholder="Prox. 2"
                                     value="{{ old('greetings_2_fr') }}"
                                     wire:model.lazy="greetings_2_fr" />
                        <x-jet-input-error for="greetings_2_fr" class="mt-2" />

                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Premier paragraphe (fr)') }}"/>

                    <div class="flex">

                        <textarea wire:model="line1_1_fr" value="{{ old('line1_1_fr') }}" class="mt-1 mr-5 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line1_1_fr" rows="2" placeholder="Prox. 1"></textarea>
                        <x-jet-input-error for="line1_1_fr" class="mt-2" />

                        <textarea wire:model="line1_2_fr" value="{{ old('line1_2_fr') }}" class="mt-1 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line1_2_fr" rows="2" placeholder="Prox. 2"></textarea>
                        <x-jet-input-error for="line1_2_fr" class="mt-2" />

                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Second Paragraphe') }}"/>

                    <div class="flex">
                        <textarea wire:model="line2_1_fr" value="{{ old('line2_1_fr') }}" class="mt-1 mr-5 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line2_1_fr" rows="2" placeholder="Prox. 1"></textarea>
                        <x-jet-input-error for="line2_1_fr" class="mt-2" />


                        <textarea wire:model="line2_2_fr" value="{{ old('line2_2_fr') }}" class="mt-1 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line2_2_fr" rows="2" placeholder="Prox. 2"></textarea>
                        <x-jet-input-error for="line2_2_fr" class="mt-2" />
                    </div>


                    <x-jet-label class="mt-2 w-full" value="{{ __('Lien - Position') }}"/>
                    <div class="mt-1 form-group flex flex-col w-full text-gray-700 rounded-lg focus:outline-none" style="width: 615px">
                        <div class="flex">
                            <div>
                                http://molitor-partners.com/
                                <select class="py-2 border rounded-lg focus:outline-none" style="width: 250px; background-color: #E5E5E5; color: #222222; border-color: #E5E5E5" id="link" wire:model="link">
                                    <option value="No view selected">{{ __('-- lien --') }}</option>
                                    <option value="{{ route('presentation-jan-21') }}">{{ __('presentation-jan-21') }}</option>
                                    <option value="{{ route('CGU') }}">{{ __('CGU') }}</option>
                                    <option value="{{ route('RGPD') }}">{{ __('RGPD') }}</option>
                                    <option value="{{ route('public') }}">{{ __('public') }}</option>
                                </select>
                            </div>

                            <select class="ml-5 py-2 pl-2 border rounded-lg focus:outline-none" style="width: 130px; background-color: #222222; color: #E5E5E5; border-color: #E5E5E5" id="link_position" wire:model="link_position">
                                <option value="1">{{ __('haut') }}</option>
                                <option value="2">{{ __('mileu') }}</option>
                                <option value="3" selected="selected">{{ __('bas') }}</option>
                            </select>


                        </div>
                        <div>
                            <x-jet-label class="mt-2" value="{{ __('Attachement') }}"/>
                            <div>
                                <x-jet-input type="file" class="mt-2" name="attachment_fr" for="attachment_fr" id="attachment_fr" placeholder="File"
                                             value="{{ old('attachment_fr') }}"
                                             wire:model.lazy="attachment_fr" />
                                <x-jet-input-error for="attachment_fr" class="mt-2" />
                            </div>
                        </div>
                    </div>

                </div>


                <div id="swapper-other" style="display:none;" class="form-group flex-col w-full" wire:ignore>

                    <x-jet-label value="{{ __('Nom du template') }}"/>
                    <div class="flex">
                        <div class="form-group flex flex-col">
                            <x-jet-input type="name" class="block mt-1" style="width: 300px;" name="name" for="name" id="name" placeholder="Entrer le nom"
                                         value="{{ old('name') }}"
                                         wire:model="name" />
                            <x-jet-input-error for="name" class="mt-2" />
                        </div>
                        <a href="javascript:SwapDivsWithClick('swapper-first','swapper-other')">
                            <img class="ml-5" width="50" src="/images/english.png">
                        </a>
                    </div>

                    <x-jet-label class="mt-1" value="{{ __('Sujet du mail (en)') }}"/>
                    <x-jet-input type="text" class="block mt-1 w-full" name="subject_1_en" id="subject_1_en" placeholder="Entrer le sujet"
                                 value="{{ old('subject_1_en') }}"
                                 wire:model.lazy="subject_1_en" />
                    <x-jet-input-error for="subject_1_en" class="mt-2" />

                    <x-jet-label class="mt-2" value="{{ __('Formules de salutation (en)') }}"/>

                    <div style="display: flex">

                        <x-jet-input type="text" class="block mt-1 mr-5 w-full" name="greetings_1_en" id="greetings_1_en" placeholder="Prox. 1"
                                     value="{{ old('greetings_1_en') }}"
                                     wire:model.lazy="greetings_1_en" />
                        <x-jet-input-error for="greetings_1_en" class="mt-2" />
                        <x-jet-input type="text" class="block mt-1 w-full" name="greetings_2_en" id="greetings_2_en" placeholder="Prox. 2"
                                     value="{{ old('greetings_2_en') }}"
                                     wire:model.lazy="greetings_2_en" />
                        <x-jet-input-error for="greetings_2_en" class="mt-2" />

                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Premier paragraphe (en)') }}"/>

                    <div class="flex">

                        <textarea wire:model="line1_1_en" value="{{ old('line1_1_en') }}" class="mt-1 mr-5 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line1_1_en" rows="2" placeholder="Prox. 1"></textarea>
                        <x-jet-input-error for="line1_1_en" class="mt-2" />

                        <textarea wire:model="line1_2_en" value="{{ old('line1_2_en') }}" class="mt-1 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line1_2_en" rows="2" placeholder="Prox. 2"></textarea>
                        <x-jet-input-error for="line1_2_en" class="mt-2" />

                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Second Paragraphe (en)') }}"/>

                    <div class="flex">
                        <textarea wire:model="line2_1_en" value="{{ old('line2_1_en') }}" class="mt-1 mr-5 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line2_1_en" rows="2" placeholder="Prox. 1"></textarea>
                        <x-jet-input-error for="line2_1_en" class="mt-2" />


                        <textarea wire:model="line2_2_en" value="{{ old('line2_2_en') }}" class="mt-1 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line2_2_en" rows="2" placeholder="Prox. 2"></textarea>
                        <x-jet-input-error for="line2_2_en" class="mt-2" />
                    </div>


                    <x-jet-label class="mt-2 w-full" value="{{ __('Lien - Position') }}"/>
                    <div class="mt-1 form-group flex flex-col w-full text-gray-700 rounded-lg focus:outline-none" style="width: 615px">
                        <div class="flex">
                            <div>
                                http://molitor-partners.com/
                                <select class="py-2 border rounded-lg focus:outline-none" style="width: 250px; background-color: #E5E5E5; color: #222222; border-color: #E5E5E5" id="link" wire:model="link">
                                    <option value="No view selected">{{ __('-- lien --') }}</option>
                                    <option value="{{ route('presentation-jan-21') }}">{{ __('presentation-jan-21') }}</option>
                                    <option value="{{ route('CGU') }}">{{ __('CGU') }}</option>
                                    <option value="{{ route('RGPD') }}">{{ __('RGPD') }}</option>
                                    <option value="{{ route('public') }}">{{ __('public') }}</option>
                                </select>
                            </div>

                            <select class="ml-5 py-2 pl-2 border rounded-lg focus:outline-none" style="width: 130px; background-color: #222222; color: #e5e5e5; border-color: #e5e5e5" id="link_position" wire:model="link_position">
                                <option value="1">{{ __('haut') }}</option>
                                <option value="2">{{ __('mileu') }}</option>
                                <option value="3" selected="selected">{{ __('bas') }}</option>
                            </select>

                        </div>
                        <div>
                            <x-jet-label class="mt-2" value="{{ __('Attachement') }}"/>
                            <div>
                                <x-jet-input type="file" class="mt-2" name="attachment_en" for="attachment_en" id="attachment_en" placeholder="File"
                                             value="{{ old('attachment_en') }}"
                                             wire:model.lazy="attachment_en" />
                                <x-jet-input-error for="attachment_en" class="mt-2" />
                            </div>
                        </div>
                    </div>

                </div>


                <div class="modal-footer">
                    <div class="text-right">
                        <button style="color: #222222"
                                x-on:click="openModal = false">
                            {{__('Close')}}
                        </button>
                        @if( $modalAction != 'readonly' )
                            <x-jet-button type="button"
                                          style=" background-color: #fd5f12"
                                          class="ml-6"
                                          wire:click="{{ $modalAction }}">
                                {{__($modalAction)}}
                            </x-jet-button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
