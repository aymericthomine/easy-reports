<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-2xl">
    <!-- Primary Navigation Menu -->
    <div class="max-w-8xl mx-auto px-4 sm:px-1">
        <div class="flex justify-between h-16">
            <div class="flex-none text-center items-center px-4 py-2">

                <!-- Logo -->

                <a href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" alt="{{ __('Dashboard') }}">
                    <img width="150" src="/images/easy-reports.png"/>
                </a>
            </div>
            <div class="mx-auto">
                <div class="flex-none text-center items-center py-4 space-x-10">
                    <!-- Private Links -->
                    @auth
                        <x-jet-nav-link href="{{ route('prospects.index') }}" :active="request()->routeIs('products.index')">
                            {{ __('IMPORT') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('companies.index')">
                            {{ __('Teachers') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{ route('contacts.index') }}" :active="request()->routeIs('documents.index')">
                            {{ __('Students') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{ route('products.index') }}" :active="request()->routeIs('documents.index')">
                            {{ __('Sentences') }}
                        </x-jet-nav-link>
                    @else
                    <!-- Public Links -->
                        <x-jet-nav-link href="#MPAbout">
                            {{ __('About Us') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link href="#MPValue">
                            {{ __('Value') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link href="#MPProcess">
                            {{ __('Process') }}
                        </x-jet-nav-link>
                    @endif
                </div>
            </div>
            <div class="flex-none rigth-4 text-center items-center text-right px-4 py-4">
                <!-- login/logout/register Links-->
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-jet-nav-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Logout') }}
                        </x-jet-nav-link>
                    </form>
                @else
                    @if (Route::has('login'))
                        <x-jet-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                            {{ __('Login') }}
                        </x-jet-nav-link>
                    @endif
                        <x-jet-nav-link href="{{ route('contact-us.index') }}" :active="request()->routeIs('contact-us')">
                            {{ __('Contact Us') }}
                        </x-jet-nav-link>
                    <!--
                    @  if (Route::has('register'))
                        <x-jet-nav-link href="{ { route('register') }}" :active="request()->routeIs('register')">
                            { { __('Register') }}
                        </x-jet-nav-link>
                    @  endif
                        -->

                @endif
            </div>
        </div>
    </div>
</nav>
