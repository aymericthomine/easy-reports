@component('mail::mp_message'){{-- PRODUIT UNE ERREUR '500' ['signature' => $signature] --}}

{{-- Greeting --}}
@if (! empty($greeting))
{{ $greeting }}
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
@component('mail::mp_button', ['url' => $actionUrl, 'color' => 'primary'])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ 'Sébastien Masson' }}
@endif

{{-- PRODUIT UNE ERREUR '500' --}}

@component('mail::mp_footer')
{{ 'Sébastien Masson' }}
@endcomponent

@endcomponent
