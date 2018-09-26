<{{ $tag or 'header' }} class="m-article-header m-article-header--default{{ (isset($variation)) ? ' '.$variation : '' }}">
    @if (!empty($title))
        @component('components.atoms._title')
            @slot('tag','h1')
            @slot('font', (isset($editorial) && $editorial) ? 'f-headline-editorial' : 'f-headline')
            @slot('itemprop','name')
            @slot('title', $title)
            @slot('title_display', $title_display ?? null)
        @endcomponent
    @endif

      {{-- Preview dates --}}
      @if ((!empty($previewDateStart) and $previewDateStart->gte(\Carbon\Carbon::today())) or (!empty($previewDateEnd) and $previewDateEnd->gte(\Carbon\Carbon::today())))
      @if (empty($previewDateStart) and empty($previewDateEnd))
      @elseif (empty($previewDateEnd) and !empty($previewDateStart))
           @component('components.atoms._date')
            @slot('tag','p')
            @slot('variation','f-previewdate')
            Member preview: <time datetime="{{ $previewDateStart->format("Y-m-d") }}">{{ $previewDateStart->format('M j, Y') }}</time>
            @endcomponent
      @elseif (empty($previewDateStart))
      @elseif ($previewDateStart and $previewDateEnd)
        @component('components.atoms._date')
            @slot('tag','p')
            @slot('variation','f-previewdate')
            Member previews:
            @if($previewDateStart->format("Y") == $previewDateEnd->format("Y"))
                @if($previewDateStart->format("M") == $previewDateEnd->format("M"))
                <time datetime="{{ $previewDateStart->format("Y-m-d") }}">{{ $previewDateStart->format('M j') }}</time>&ndash;<time datetime="{{ $previewDateEnd->format("Y-m-d") }}">{{ $previewDateEnd->format('j, Y') }}</time>
              @else
                <time datetime="{{ $previewDateStart->format("Y-m-d") }}">{{ $previewDateStart->format('M j') }}</time>&ndash;<time datetime="{{ $previewDateEnd->format("Y-m-d") }}">{{ $previewDateEnd->format('M j, Y') }}</time>
              @endif
            @else
            <time datetime="{{ $previewDateStart->format("Y-m-d") }}">{{ $previewDateStart->format('M j, Y') }}</time>&ndash;<time datetime="{{ $previewDateEnd->format("Y-m-d") }}">{{ $previewDateEnd->format('M j, Y') }}</time>
            @endif
        @endcomponent
      @endif
      @endif

      {{-- Regular dates --}}
      @if (isset($formattedDate))
        @component('components.atoms._date')
            @slot('tag','p')
            {!! $formattedDate !!}
        @endcomponent
      @elseif (empty($dateStart) and empty($dateEnd))
     @elseif (empty($dateEnd) and !empty($dateStart))
           @component('components.atoms._date')
            @slot('tag','p')
            <time datetime="{{ $dateStart->format("Y-m-d") }}" itemprop="startDate">{{ $dateStart->format('M j, Y') }}</time>
            @endcomponent
      @elseif (empty($dateStart))
    @elseif ($dateStart and $dateEnd)
        @component('components.atoms._date')
            @slot('tag','p')
            @if($dateStart->format("Y") == $dateEnd->format("Y"))
            <time datetime="{{ $dateStart->format("Y-m-d") }}" itemprop="startDate">{{ $dateStart->format('M j') }}</time>&ndash;<time datetime="{{ $dateEnd->format("Y-m-d") }}" itemprop="endDate">{{ $dateEnd->format('M j, Y') }}</time>
            @else
             <time datetime="{{ $dateStart->format("Y-m-d") }}" itemprop="startDate">{{ $dateStart->format('M j, Y') }}</time>&ndash;<time datetime="{{ $dateEnd->format("Y-m-d") }}" itemprop="endDate">{{ $dateEnd->format('M j, Y') }}</time>
            @endif
        @endcomponent
    @elseif (!empty($date))
        @component('components.atoms._date')
            @slot('tag','p')
            <time datetime="{{ $date->format("Y-m-d") }}" itemprop="startDate">{{ $date->format('F j, Y') }}</time>
        @endcomponent
    @endif
    @if (!empty($type))
        @component('components.atoms._type')
            @slot('tag','p')
            {{ $type }}
        @endcomponent
    @endif
</{{ $tag or 'header' }}>
