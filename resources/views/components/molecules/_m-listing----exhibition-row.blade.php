<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}{{ $item->closingSoon ? " m-listing--limited" : "" }}{{ $item->nowOpen ? " m-listing--new" : "" }}{{ $item->exclusive ? " m-listing--membership" : "" }}">
  <a href="{{ $item->slug }}" class="m-listing__link">
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
        @if ($item->image)
            @component('components.atoms._img')
                @slot('image', $item->image)
                @slot('sizes', $imageSizes ?? '')
            @endcomponent
        @endif
    </span>
    <span class="m-listing__meta">
        @if ($item->closingSoon)
            @component('components.atoms._type')
                @slot('variation', 'type--limited')
                Closing Soon
            @endcomponent
        @elseif ($item->nowOpen)
            @component('components.atoms._type')
                @slot('variation', 'type--new')
                Now Open
            @endcomponent
        @elseif ($item->exclusive)
            @component('components.atoms._type')
                @slot('variation', 'type--membership')
                Member Exclusive
            @endcomponent
        @else
            @component('components.atoms._type')
                {{ $item->type }}
            @endcomponent
        @endif
        <br>
        @component('components.atoms._title')
            {{ $item->title }}
        @endcomponent
        <br>
        @if (isset($variation) && !strrpos($variation, "--row"))
            @component('components.atoms._date')
                Through {{ $item->dateEnd->format('M j, Y') }}
            @endcomponent
        @else
            <span class="m-listing__meta-bottom">
                @component('components.atoms._date')
                    {{ $item->dateStart->format('M j, Y') }} &ndash; {{ $item->dateEnd->format('M j, Y') }}
                @endcomponent
            </span>
        @endif
    </span>
  </a>
</{{ $tag ?? 'li' }}>
