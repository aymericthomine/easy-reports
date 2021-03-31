<div name="template">

    @if( isset($greetings) && !empty($greetings) )
        <div name="header">{{ $greetings }} {{ $toProximity }}</div><br>
    @endif

    @if( isset($line1) && !empty($line1) )
        <div class="short-text">{{ $line1 }}</div><br>
    @endif

    @if( isset($link) && !empty($link) )
        <div><a href="{{ $link }}">{{ $linkLabel }}</a></div><br>
    @endif

    @if( isset($line2) && !empty($line2) )
        <div class="short-text">{{ $line2 }}</div><br>
    @endif

    @if( isset($salutations) && !empty($salutations) )
        <div class="short-text">{{ $salutations }}</div><br>
    @endif

    @if( isset($fromProximity) && !empty($fromProximity) )
        <div class="short-text">{{ $fromProximity }}</div><br>
    @endif

    @if( isset($signature) && !empty($signature) )
        @include('emails.signatures.'. $signature)
    @endif

    @if( isset($lang) == 'en' && !empty($unsubscribe) )
        <a style="color: #E0E0E0; text-decoration: none" href="{{ $unsubscribe }}">{{ __('Unsubscribe') }}</a>

       {{--
        @elseif
            <a href="{{ $unsubscribe }}">{{ __('Se désabonner') }}</a>
        --}}
    @endif

</div>

<style>
    .short-text {
        text-overflow: ellipsis;
        white-space: pre-wrap;
        overflow: hidden;
    }
</style>

<!--
Remplace par Manuel pour prendre en charge le preformattage
<style>
    .short-text {
        text-overflow: ellipsis;
        white-space: break-spaces;
        overflow: hidden;
    }
</style>
-->
