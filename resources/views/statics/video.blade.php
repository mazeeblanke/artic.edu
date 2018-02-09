@extends('layouts.app')

@section('content')

<article class="o-article o-article--video" data-behavior="internalLinksScroll">

    @component('components.molecules._m-article-header')
        @slot('title', $article->title)
        @slot('date', $article->date)
        @slot('type', $article->type)
        @slot('intro', $article->intro)
    @endcomponent

    @component('components.molecules._m-media')
        @slot('variation', 'o-blocks__block')
        @slot('item', $article->video)
    @endcomponent

    <div class="o-article__body o-blocks" data-behavior="articleBodyInViewport">
        @component('components.blocks._blocks')
            @slot('editorial', ($article->articleType === 'editorial'))
            @slot('blocks', $article->blocks ?? null)
            @slot('dropCapFirstPara', ($article->articleType === 'editorial'))
        @endcomponent

        <div class="o-article__body-actions">
            @component('components.molecules._m-article-actions')
                @slot('articleType', $article->articleType)
            @endcomponent
        </div>
    </div>
</article>

@if ($article->relatedVideos)
    @component('components.molecules._m-title-bar')
        Related Videos
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($article->relatedVideos as $item)
            @component('components.molecules._m-listing----article-minimal')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
@endif


@if ($article->recentlyViewedArtworks)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'Clear your history', 'href' => '#')))
        Recently Viewed
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--scroll@large o-grid-listing--scroll@xlarge  o-grid-listing--gridlines-cols')
        @slot('cols_large',(sizeof($article->recentlyViewedArtworks) > 6) ? '12' : '6')
        @slot('cols_xlarge',(sizeof($article->recentlyViewedArtworks) > 6) ? '12' : '6')
        @slot('behavior','dragScroll')
        @foreach ($article->recentlyViewedArtworks as $item)
            @component('components.molecules._m-listing----artwork-minimal')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
    @component('components.atoms._hr')
        @slot('variation','hr--flush-topp')
    @endcomponent
@endif

@endsection
