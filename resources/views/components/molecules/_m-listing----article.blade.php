<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!}>
    <a href="{!! route('articles.show', $item) !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
            @if (isset($image) || $item->imageFront('hero'))
                @component('components.atoms._img')
                    @slot('image', $image ?? $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @if ($item->videoFront)
                    @component('components.atoms._video')
                        @slot('video', $item->videoFront)
                        @slot('autoplay', true)
                        @slot('loop', true)
                        @slot('muted', true)
                        @slot('title', $item->videoFront['fallbackImage']['alt'] ?? $item->imageFront('hero')['alt'] ?? $image['alt'] ?? null)
                    @endcomponent
                    @component('components.atoms._media-play-pause-video')
                    @endcomponent
                @endif
            @else
                <span class="default-img"></span>
            @endif
            @if ($item->isVideo)
                <svg class="icon--play--48"><use xlink:href="#icon--play--48" /></svg>
            @endif
        </span>
        <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
            <em class="type f-tag">{{ $item->subtype }}</em>
            <br>
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                @slot('title', $item->title)
                @slot('title_display', $item->title_display)
            @endcomponent
            <br>
            <span class="intro {{ $captionFont ?? 'f-caption' }}">{!! $item->list_description !!}</span>
        </span>
    </a>
</{{ $tag or 'li' }}>
