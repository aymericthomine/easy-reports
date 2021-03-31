<table>
    <tr>
        <td>
            @if (! empty($image))
![product] ({{ asset( 'images/' . $image . '.jpg') }})
            @endif
        </td>
    </tr>
    <tr>
        <td>
            @if (! empty($image))
                @include('includes.images.' . $image )
            @endif
        </td>
    </tr>
    <tr>
        <td>
            @if (! empty($signature))
                @include('includes.images.' . $signature )
            @endif
        </td>
    </tr>
</table>

