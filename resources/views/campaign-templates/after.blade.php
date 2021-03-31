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


            <form wire:submit.prevent="closeModal()" style="padding-left: 60px; padding-right: 60px; padding-bottom: 20px;" class="flex flex-col justify-center">
                @method( isset($campaign_template_id) ? 'PUT' : 'POST' )
                @csrf

                <h2 class="text-3xl font-bold mt-5 text-center">
                    {{__(Str::title($modalAction))}}
                </h2>

                <div id="swapper-first" style="display:flex;" class="form-group flex-col w-full" wire:ignore>

                    <x-jet-label value="{{ __('Nom du template') }}"/>
                    <div class="flex">
                        <div class="form-group flex flex-col">
                            <x-jet-input type="name" class="block mt-1" style="width: 300px;" name="name" for="name" id="name" placeholder="Entrer le nom"
                                         value="{{ old('name') }}"
                                         wire:model="name"
                                         action="{{ $modalAction }}"
                            />
                            <x-jet-input-error for="name" class="mt-2" />
                        </div>
                        <a href="javascript:SwapDivsWithClick('swapper-first','swapper-other')">
                            <img class="ml-5" width="50" src="/images/france.png">
                        </a>
                        <div class="mt-2" style="height: 20px">
                        <x-jet-button wire:click="preTranslate()" type="button" style=" background-color: #fd5f12" class="ml-6">
                            {{__('Traduction automatique en anglais')}}
                        </x-jet-button>
                        <x-jet-button wire:click="preFill()" type="button" style=" background-color: #fd5f12" class="ml-6">
                            {{__('Copie proximité 1 vers 2')}}
                        </x-jet-button>
                        </div>
                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Sujet du mail (fr)') }}"/>
                    <div style="display: flex">
                        <x-jet-input type="text" class="block mt-1 mr-5 w-full" name="subject_1_fr" id="subject_1_fr" placeholder="Sujet prox. 1"
                                     value="{{ old('subject_1_fr') }}"
                                     wire:model.lazy="subject_1_fr" />
                        <x-jet-input-error for="subject_1_fr" class="mt-2" />
                        <x-jet-input type="text" class="block mt-1 w-full" name="subject_2_fr" id="subject_2_fr" placeholder="Sujet prox. 2"
                                     value="{{ old('subject_2_fr') }}"
                                     wire:model.lazy="subject_2_fr"
                                     action="{{ $modalAction }}"
                        />
                        <x-jet-input-error for="subject_2_fr" class="mt-2" />
                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Formules de salutation (fr)') }}"/>
                    <div style="display: flex">
                        <x-jet-input type="text" class="block mt-1 mr-5 w-full" name="greetings_1_fr" id="greetings_1_fr" placeholder="Salutations prox. 1"
                                     value="{{ old('greetings_1_fr') }}"
                                     wire:model.lazy="greetings_1_fr" />
                        <x-jet-input-error for="greetings_1_fr" class="mt-2" />
                        <x-jet-input type="text" class="block mt-1 w-full" name="greetings_2_fr" id="greetings_2_fr" placeholder="Salutations prox. 2"
                                     value="{{ old('greetings_2_fr') }}"
                                     wire:model.lazy="greetings_2_fr"
                                     action="{{ $modalAction }}"
                        />
                        <x-jet-input-error for="greetings_2_fr" class="mt-2" />
                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Premier paragraphe (fr)') }}"/>
                    <div class="flex">
                        <textarea wire:model="line1_1_fr" value="{{ old('line1_1_fr') }}" class="mt-1 mr-5 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line1_1_fr" rows="2" placeholder="Paragraphe prox. 1"></textarea>
                        <x-jet-input-error for="line1_1_fr" class="mt-2" />
                        <textarea wire:model="line1_2_fr" value="{{ old('line1_2_fr') }}" class="mt-1 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line1_2_fr" rows="2" placeholder="Paragraphe prox. 2"></textarea>
                        <x-jet-input-error for="line1_2_fr" class="mt-2" />
                    </div>

                    <x-jet-label class="mt-2 w-full" value="{{ __('Lien') }}"/>
                    <div class="flex">
                        <div>
                            <select class="py-2 border rounded-lg focus:outline-none" style="width: 500px; background-color: #E5E5E5; color: #222222; border-color: #E5E5E5" id="link" wire:model="link">
                                <option value="" @if(""==$link) selected="selected" @endif>{{ __('-- no link --') }}</option>
                                @foreach(scandir(resource_path('views/links')) as $u)
                                    @if($u != '.' && $u != '..')
                                        <option value="{{ basename($u, '.blade.php') }}" @if(basename($u, '.blade.php') == $link) selected="selected" @endif>{{ basename($u, '.blade.php') }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Second Paragraphe (fr)') }}"/>
                    <div class="flex">
                        <textarea wire:model="line2_1_fr" value="{{ old('line2_1_fr') }}" class="mt-1 mr-5 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line2_1_fr" rows="2" placeholder="Paragraphe prox. 1"></textarea>
                        <x-jet-input-error for="line2_1_fr" class="mt-2" />
                        <textarea wire:model="line2_2_fr" value="{{ old('line2_2_fr') }}" class="mt-1 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line2_2_fr" rows="2" placeholder="Paragraphe prox. 2"></textarea>
                        <x-jet-input-error for="line2_2_fr" class="mt-2" />
                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Formules de politesse (fr)') }}"/>
                    <div style="display: flex">
                        <x-jet-input type="text" class="block mt-1 mr-5 w-full" name="salutations_1_fr" id="salutations_1_fr" placeholder="Formule de politesse prox. 1"
                                     value="{{ old('salutations_1_fr') }}"
                                     wire:model.lazy="salutations_1_fr" />
                        <x-jet-input-error for="salutations_1_fr" class="mt-2" />
                        <x-jet-input type="text" class="block mt-1 w-full" name="salutations_2_fr" id="salutations_2_fr" placeholder="Formule de politesse prox. 2"
                                     value="{{ old('salutations_2_fr') }}"
                                     wire:model.lazy="salutations_2_fr"
                                     action="{{ $modalAction }}"
                        />
                        <x-jet-input-error for="salutations_2_fr" class="mt-2" />
                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Attachement (fr)') }}"/>
                    <div style="display: flex">
                        <x-jet-input type="file" class="block mt-1 mr-5 w-full" name="file_fr" id="file_fr" placeholder="Choisir un fichier à joindre au mail"
                                     value="{{ old('file_fr') }}"
                                     wire:model.lazy="file_fr" />
                        <x-jet-input-error for="file_fr" class="mt-2" />
                        <x-jet-input type="text" class="block mt-1 w-full" name="attachment_fr" id="attachment_fr" placeholder="Choisir un fichier à joindre au mail"
                                     value="{{ old('attachment_fr') }}"
                                     wire:model.lazy="attachment_fr"
                                     action="{{ $modalAction }}"
                        />
                        <x-jet-input-error for="attachment_fr" class="mt-2" />
                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Attachement (fr)') }}"/>
                    <div style="display: flex">
                        <x-jet-input type="text" class="block mt-1 mr-5 w-full" name="file_fr" for="file_fr" id="file_fr" placeholder="Choisir un fichier à joindre au mail"
                                     value="{{ old('file_fr') }}"
                                     wire:model.lazy="file_fr"
                                     action="{{ $modalAction }}"
                        />
                        <x-jet-input-error for="file_fr" class="mt-2" />
                    </div>

                    <x-jet-label class="mt-2 w-full" value="{{ __('Image') }}"/>
                    <div class="flex">
                        <div>
                            <select class="py-2 border rounded-lg focus:outline-none" style="width: 300px; background-color: #E5E5E5; color: #222222; border-color: #E5E5E5" id="image" wire:model="image">
                                <option value="" @if(""==$image) selected="selected" @endif>{{ __('-- no image --') }}</option>
                                @foreach( ['voeux_2021', 'voeux_2021_62', 'voeux_2021_100'] as $i )
                                    <option value="{{ $i }}" @if($i==$image) selected="selected" @endif>{{ $i }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-2 form-group flex flex-col w-full">
                        <x-jet-label value="{{ __('Unsubscribe') }}" />
                        <p class="mt-1">
                            <input type="checkbox" id="unsubscribe" name="unsubscribe" class="unsubscribe" wire:model="unsubscribe" {{ $unsubscribe ? 'checked="checked"' : '' }}/>
                            <label for="unsubscribe"></label>
                        </p>
                    </div>

                </div>


                <div id="swapper-other" style="display:none;" class="form-group flex-col w-full" wire:ignore>

                    <x-jet-label value="{{ __('Nom du template') }}"/>
                    <div class="flex">
                        <div class="form-group flex flex-col">
                            <x-jet-input type="name" class="block mt-1" style="width: 300px;" name="name" for="name" id="name" placeholder="Entrer le nom"
                                         value="{{ old('name') }}"
                                         wire:model="name"
                                         action="{{ $modalAction }}"
                            />
                            <x-jet-input-error for="name" class="mt-2" />
                        </div>
                        <a href="javascript:SwapDivsWithClick('swapper-first','swapper-other')">
                            <img class="ml-5" width="50" src="/images/english.png">
                        </a>
                        <div class="mt-2" style="height: 20px">
                        <x-jet-button wire:click="preTranslate()" type="button" style=" background-color: #fd5f12" class="ml-6">
                            {{__('Traduction automatique en anglais')}}
                        </x-jet-button>
                        <x-jet-button wire:click="preFill()" type="button" style=" background-color: #fd5f12" class="ml-6">
                            {{__('Copie proximité 1 vers 2')}}
                        </x-jet-button>
                        </div>
                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Sujet du mail (en)') }}"/>
                    <div style="display: flex">
                        <x-jet-input type="text" class="block mt-1 mr-5 w-full" name="subject_1_en" id="subject_1_en" placeholder="Sujet prox. 1"
                                     value="{{ old('subject_1_en') }}"
                                     wire:model.lazy="subject_1_en" />
                        <x-jet-input-error for="subject_1_en" class="mt-2" />
                        <x-jet-input type="text" class="block mt-1 w-full" name="subject_2_en" id="subject_2_en" placeholder="Sujet prox. 2"
                                     value="{{ old('subject_2_en') }}"
                                     wire:model.lazy="subject_2_en"
                                     action="{{ $modalAction }}"
                        />
                        <x-jet-input-error for="subject_2_en" class="mt-2" />
                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Formules de salutation (en)') }}"/>
                    <div style="display: flex">
                        <x-jet-input type="text" class="block mt-1 mr-5 w-full" name="greetings_1_en" id="greetings_1_en" placeholder="Salutations prox. 1"
                                     value="{{ old('greetings_1_en') }}"
                                     wire:model.lazy="greetings_1_en" />
                        <x-jet-input-error for="greetings_1_en" class="mt-2" />
                        <x-jet-input type="text" class="block mt-1 w-full" name="greetings_2_en" id="greetings_2_en" placeholder="Salutations prox. 2"
                                     value="{{ old('greetings_2_en') }}"
                                     wire:model.lazy="greetings_2_en"
                                     action="{{ $modalAction }}"
                        />
                        <x-jet-input-error for="greetings_2_en" class="mt-2" />
                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Premier paragraphe (en)') }}"/>
                    <div class="flex">
                        <textarea wire:model="line1_1_en" value="{{ old('line1_1_en') }}" class="mt-1 mr-5 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line1_1_en" rows="2" placeholder="Paragraphe prox. 1"></textarea>
                        <x-jet-input-error for="line1_1_en" class="mt-2" />
                        <textarea wire:model="line1_2_en" value="{{ old('line1_2_en') }}" class="mt-1 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line1_2_en" rows="2" placeholder="Paragraphe prox. 2"></textarea>
                        <x-jet-input-error for="line1_2_en" class="mt-2"
                                           action="{{ $modalAction }}"
                        />
                    </div>

                    <x-jet-label class="mt-2 w-full" value="{{ __('Lien') }}"/>
                    <div class="flex">
                        <div>
                            <select class="py-2 border rounded-lg focus:outline-none" style="width: 500px; background-color: #E5E5E5; color: #222222; border-color: #E5E5E5" id="link" wire:model="link">
                                <option value="" @if(""==$link) selected="selected" @endif>{{ __('-- no link --') }}</option>
                                @foreach(scandir(resource_path('views/links')) as $u)
                                    @if($u != '.' && $u != '..')
                                        <option value="{{ basename($u, '.blade.php') }}" @if(basename($u, '.blade.php') == $link) selected="selected" @endif>{{ basename($u, '.blade.php') }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Second Paragraphe (en)') }}"/>
                    <div class="flex">
                        <textarea wire:model="line2_1_en" value="{{ old('line2_1_en') }}" class="mt-1 mr-5 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line2_1_en" rows="2" placeholder="Paragraphe prox. 1"></textarea>
                        <x-jet-input-error for="line2_1_en" class="mt-2" />
                        <textarea wire:model="line2_2_en" value="{{ old('line2_2_en') }}" class="mt-1 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" name="line2_2_en" rows="2" placeholder="Paragraphe prox. 2"></textarea>

                        <x-jet-input-error for="line2_2_en" class="mt-2" />
                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Formules de politesse (en)') }}"/>
                    <div style="display: flex">
                        <x-jet-input type="text" class="block mt-1 mr-5 w-full" name="salutations_1_en" id="salutations_1_en" placeholder="Formule de politesse prox. 1"
                                     value="{{ old('salutations_1_en') }}"
                                     wire:model.lazy="salutations_1_en" />
                        <x-jet-input-error for="salutations_1_en" class="mt-2" />
                        <x-jet-input type="text" class="block mt-1 w-full" name="salutations_2_en" id="salutations_2_en" placeholder="Formule de politesse prox. 2"
                                     value="{{ old('salutations_2_en') }}"
                                     wire:model.lazy="salutations_2_en"
                                     action="{{ $modalAction }}"
                        />
                        <x-jet-input-error for="salutations_2_en" class="mt-2" />
                    </div>

                    <x-jet-label class="mt-2" value="{{ __('Attachement (en)') }}"/>
                    <div style="display: flex">
                        <x-jet-input type="file" class="block mt-1 mr-5 w-full" name="file_en" id="file_en" placeholder="Choisir un fichier à joindre au mail"
                                     value="{{ old('file_en') }}"
                                     wire:model.lazy="file_en" />
                        <x-jet-input-error for="file_en" class="mt-2" />
                        <x-jet-input type="text" class="block mt-1 w-full" name="attachment_en" id="attachment_en" placeholder="Choisir un fichier à joindre au mail"
                                     value="{{ old('attachment_en') }}"
                                     wire:model.lazy="attachment_en"
                                     action="{{ $modalAction }}"
                        />
                        <x-jet-input-error for="attachment_en" class="mt-2" />
                    </div>

                    <x-jet-label class="mt-2 w-full" value="{{ __('Image') }}"/>
                    <div class="flex">
                        <div>
                            <select class="py-2 border rounded-lg focus:outline-none" style="width: 300px; background-color: #E5E5E5; color: #222222; border-color: #E5E5E5" id="image" wire:model="image">
                                <option value="" @if(""==$image) selected="selected" @endif>{{ __('-- no image --') }}</option>
                                @foreach( ['voeux_2021', 'voeux_2021_62', 'voeux_2021_100'] as $i )
                                    <option value="{{ $i }}" @if($i == $image) selected="selected" @endif>{{ $i }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-2 form-group flex flex-col w-full">
                        <x-jet-label value="{{ __('Unsubscribe') }}" />
                        <p class="mt-1">
                            <x-jet-input type="checkbox" name="test" value="value1" class="unsubscribe" id="unsubscribe" wire:model.lazy="unsubscribe"/>
                            <label for="unsubscribe"></label>
                        </p>
                    </div>


                    <style>
                        input[type="checkbox"].unsubscribe {
                            display: none;
                        }
                        input[type="checkbox"].unsubscribe + label {
                            box-sizing: border-box;
                            display: inline-block;
                            width: 3rem;
                            height: 1.5rem;
                            border-radius: 1.5rem;
                            padding:2px;
                            background-color: #fe2419 ;
                            transition: all 0.5s ;
                        }
                        input[type="checkbox"].unsubscribe + label::before {
                            box-sizing: border-box;
                            display: block;
                            content: "";
                            height: calc(1.5rem - 4px);
                            width: calc(1.5rem - 4px);
                            border-radius: 50%;
                            background-color: #fff;
                            transition: all 0.5s ;
                        }
                        input[type="checkbox"].unsubscribe:checked + label {
                            background-color: #03cc00 ;
                        }
                        input[type="checkbox"].unsubscribe:checked + label::before {
                            margin-left: 1.5rem ;
                        }
                    </style>

                </div>


                <div class="modal-footer">
                    <div class="text-right">
                        <button style="color: #222222"
                                x-on:click="openModal = false">
                            {{__('Close')}}
                        </button>
                        @if( $modalAction != 'view' )
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
