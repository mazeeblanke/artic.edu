@if ( !empty( $items ) )
    <div class="g-search__autocomplete" data-autocomplete-list>
        <ul>
            @foreach ($items as $item)
                <li>
                    <a href="{{ $item['url'] }}">
                        @component('components.atoms._img')
                            @slot('image', $item['image'])
                            @slot('sizes', '40px')
                        @endcomponent
                        {{ $item['text'] }}
                    </a>
                </li>
            @endforeach
        </ul>
        <p class="g-search__autocomplete-all f-buttons">
            <a href="{{ isset($seeAllUrl) ? $seeAllUrl : route('search') }}">See {{ $resultCount }} {{ $resultCount == 1 ? 'result' : 'results' }} for {{ $term }} &rsaquo;</a>
        </p>
    </div>
@endif
