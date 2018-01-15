<ul class="m-article-actions{{ (isset($variation)) ? ' '.$variation : '' }}">
    <li class="m-article-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--icon'.((isset($articleType) and $articleType === 'editorial') ? ' btn--senary' : ''))
            @slot('font', '')
            @slot('icon', 'icon--share--24')
            @slot('behavior','sharePage')
        @endcomponent
    </li>
    @if (isset($articleType) and $articleType !== 'exhibition')
    <li class="m-article-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--secondary btn--icon')
            @slot('font', '')
            @slot('icon', 'icon--print--24')
            @slot('behavior','printPage')
        @endcomponent
    </li>
    @endif
</ul>
