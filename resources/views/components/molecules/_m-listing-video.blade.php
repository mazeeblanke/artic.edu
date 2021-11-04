@if ($item->videoFront)
    @php
        // WEB-2339, WEB-2335: Work around null array access
        $altTextSource = $item->videoFront['fallbackImage']
            ?? $image['alt']
            ?? $item->imageFront('default')
            ?? $item->imageFront('hero')
            ?? $item->imageFront('listing')
            ?? null;
    @endphp
    @component('components.atoms._video')
        @slot('video', $item->videoFront)
        @slot('autoplay', true)
        @slot('loop', true)
        @slot('muted', true)
        @slot('title', is_array($altTextSource) ? $altTextSource['alt'] : null)
    @endcomponent
    @component('components.atoms._media-play-pause-video')
    @endcomponent
@endif
