@component('mail::message')
    {{-- Greeting --}}
    @if (! empty($greeting))
        {{ $greeting }}
    @endif


    @if (! empty($image))
        ![DemoImage](https://molitor-partners.com/images/instagram.png)

        {{ $image }}
    @endif

    @if (! empty($signature))
        @include('includes.signatures.' . $signature)

        {{ $signature }}
    @endif
@endcomponent
