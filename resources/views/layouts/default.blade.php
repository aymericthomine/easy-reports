<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
            @include('includes.head')

            @guest
                @include('includes.head_public')
            @endguest
    </head>
<body>
    <div class="min-h-screen @auth bg-gray-300 @endauth">
        <header class="z-50 w-full row fixed @guest @endguest" >
            @include('includes.header')
        </header>

        <div id="main" class="row py-3">
            @yield('content')
        </div>
    </div>
    <footer class="row">
            @include('includes.footer')
    </footer>
</body>
</html>
