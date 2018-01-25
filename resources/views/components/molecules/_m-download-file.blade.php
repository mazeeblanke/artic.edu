<p class="m-download-file">
    @if (isset($file['thumb']))
        @component('components.atoms._img')
            @slot('src', $file['thumb']['src'] ?? '')
            @slot('srcset', $file['thumb']['srcset'] ?? '')
            @slot('sizes', $file['thumb']['sizes'] ?? '')
            @slot('width', $file['thumb']['width'] ?? '')
            @slot('height', $file['thumb']['height'] ?? '')
            @slot('class', 'm-download-file__img')
        @endcomponent
    @endif
    <span class="m-download-file__meta f-secondary">
        @if (isset($file['name']))
            {{ $file['name'] }}@if (isset($file['extension'])).{{ strtolower($file['extension']) }}@endif
        @endif
        <br>
        @if (isset($file['extension']))
            {{ strtoupper($file['extension']) }}@if (isset($file['size'])){{ ', '}}@endif
        @endif
        @if (isset($file['size']))
            {{ $file['size'] }}
        @endif
    </span>
    @component('components.atoms._btn')
        @slot('variation', 'btn--secondary btn--icon-sq m-download-file__button')
        @slot('font', '')
        @slot('icon', 'icon--download--24')
        @slot('tag', 'a')
        @slot('href', $file['link'])
        @slot('download', true)
    @endcomponent
</p>
