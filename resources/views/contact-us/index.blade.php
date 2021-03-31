<x-guest-layout>
    <x-jet-authentication-card>

        @if( isset($success) )

            <x-slot name="logo">
                <a href="/">
                    <img style="margin: auto" width="200" src="/images/Logo-avec-arrows.png"/>
                    <div class="sm:mx-auto sm:w-full sm:max-w-md">
                        <h2 class="mt-10 text-3xl font-bold text-center">
                            {{ __('Successfully Sent') }}
                        </h2>
                    </div>
                </a>
            </x-slot>

            <div class="text-center">
                <p>{{ __('Thanks for contacting Molitor Partners!') }}</p> </br>
                <p>{{ __('We will get back to you soon.') }}</p>
            </div>

            <div class="mt-5">
                <div class="text-center">
                    <a style="background-color: #fd5f12" class="text-white py-2 px-4 rounded" href="{{ url('/') }}">{{ __('Back') }}</a>
                </div>
            </div>

        @else

            <x-slot name="logo">
                <a href="/">
                    <img class="mx-auto mt-2" width="150" src="/images/Logo-avec-arrows.png"/>
                    <div class="sm:mx-auto sm:w-full sm:max-w-md">
                </a>
                <h2 class="mt-2 text-3xl font-bold text-center">
                    {{ __('Contact Us') }}
                </h2>
                <p class="text-center">
                    {{ __('Or') }}
                    <a href="{{ route('login') }}" style="color: #fd5f12" class="font-medium color-molitor hover:text-gray-700 focus:outline-none focus:underline transition ease-in-out duration-150">
                        {{ __('sign in to your account') }}
                    </a>
                </p>
                </div>
            </x-slot>

            <div class="form">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data- dismiss="alert">×</button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data- dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                <form method="post" action="{{url('contact-us/send')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div style="display: flex">
                        <div class="mt-4 mr-4">
                            <x-jet-label value="{{ __('Firstname') }}" />
                            <x-jet-input type="text" name="firstname" for="name" class="block mt-1 w-full" id="firstname" placeholder="{{ __('Enter your firstname') }}" data-rule="minlen:4" />
                            <div class="validation"></div>
                        </div>
                        <div class="mt-4 mr-4">
                            <x-jet-label value="{{ __('Name') }}" />
                            <x-jet-input type="text" name="name" for="name" class="block mt-1 w-full" id="name" placeholder="{{ __('Enter your name') }}" data-rule="minlen:4" />
                            <div class="validation"></div>
                        </div>

                    </div>
                    <div class="mt-4">
                        <input id="full_number" name="full_number" type="hidden"/>
                        <x-jet-label class="mb-1" value="{{ __('Phone') }}" />
                        <x-jet-input type="tel" class="block mt-1 w-full" name="phone" for="phone" id="phone"  data-rule="minlen:4" />
                        <div class="validation"></div>
                    </div>
                    <div class="mt-4">
                        <x-jet-label value="{{ __('Email') }}" />
                        <x-jet-input type="email" class="block mt-1 w-full" name="email" for="email" id="email" placeholder="{{ __('Enter your email') }}" data-rule="email" />
                        <div class="validation"></div>
                    </div>
                    <div class="mt-4">
                        <x-jet-label value="{{ __('Message') }}" />
                        <textarea class="mt-1 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="2" name="message" for="message" rows="3" data-rule="required" placeholder="{{ __('Enter your message') }}"></textarea>
                        <div class="validation"></div>
                    </div>

                    <div class="mt-4 mb-4 g-recaptcha"
                         data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                    </div>

                   <!-- <div class="mt-4">
                        <x-jet-label style="font-weight: bold" value="{{ __('Please accept the Molitor-Partners Terms of Service') }}" />
                        <input type="checkbox" class="mt-2" name="checkbox" for="checkbox" id="checkbox" data-rule="checkbox"/>
                        <a href="/RGPD" target="_blank" rel="noopener" class="font-medium text-sm text-gray-700">{{ __('Link to Terms of Service') }}</a>
                        <div class="validation"></div>
                    </div> -->

                    <div class="text-right">
                        <div class="mt-5">
                            <a style="color: #222222" class="mt-5" href="{{ url('/') }}">{{ __('Back') }}</a>
                            <x-jet-button style="background-color: #fd5f12" class="ml-6" type="submit" name="send" title="Send Message">{{ __('Send Request') }}</x-jet-button>
                        </div>
                    </div>
                </form>
            </div>

        @endif

    </x-jet-authentication-card>
</x-guest-layout>

<script src='https://www.google.com/recaptcha/api.js'></script>

<script src="{{ asset('js/intlTelInput.js') }}"></script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        // allowDropdown: false,
        autoHideDialCode: false,
        // autoPlaceholder: "off",
        // dropdownContainer: document.body,
        // excludeCountries: ["us"],
        // formatOnDisplay: false,
        initialCountry: "auto",
        geoIpLookup: function(callback) {
            $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        hiddenInput: "full_number",
        // localizedCountries: { 'de': 'Deutschland' },
        nationalMode: false,
        onlyCountries: [ "fr", "gb", "be", "lu" ],
        placeholderNumberType: "MOBILE",
        preferredCountries: [ "gb" ],
        separateDialCode: true,
        utilsScript: "js/utils.js",
    });
</script>
