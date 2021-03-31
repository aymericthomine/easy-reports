@component('mail::message')

    @if (! empty($image))
        @include('includes.signatures.' . $image )
    @endif

    @if (! empty($signature))
        @include('includes.signatures.' . $signature )
    @endif

@endcomponent
