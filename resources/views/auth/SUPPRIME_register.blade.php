<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img style="margin: auto" width="200" src="http://molitor-partners.com/wp-content/uploads/2020/02/Logo-avec-arrows.png"/>
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <h2 class="mt-10 text-3xl font-bold text-center">
                    Create a new account
                </h2>
                <p class="text-center">
                    Or
                    <a href="{{ route('login') }}" style="color: #fd5f12" class="font-medium color-molitor hover:text-gray-700 focus:outline-none focus:underline transition ease-in-out duration-150">
                        sign in to your account
                    </a>
                </p>
            </div>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a style="color: #fd5f12" class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button style="background-color: #fd5f12" class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
