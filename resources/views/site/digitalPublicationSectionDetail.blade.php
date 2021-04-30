@extends('layouts.app')

@section('content')

<article class="o-article">
    @component('components.molecules._m-sidebar-toggle')
        @slot('title', $item->digitalPublication->title_display ?? $item->digitalPublication->title)
    @endcomponent

    <div class="o-article__primary-actions o-article__primary-actions--digital-publication">
        @component('components.molecules._m-article-actions----digital-publication')
            @slot('digitalPublication', $item->digitalPublication)
            @slot('currentSection', $item)
            @slot('pdfDownloadPath', $item->present()->pdfDownloadPath())
            @slot('citeAs', $item->cite_as)
        @endcomponent
    </div>

    @if ($item->type == \App\Models\DigitalPublicationSection::TEXT)
        @component('components.molecules._m-article-header----journal-article')
            @slot('title', $item->present()->title)
            @slot('title_display', $item->present()->title_display)
            @slot('img', $item->imageFront('hero'))
        @endcomponent
    @else
        @component('components.molecules._m-article-header')
            @slot('headerType', 'generic')
            @slot('title', $item->present()->title)
            @slot('title_display', $item->present()->title_display ?? null) {{-- TODO: Populate this? --}}
        @endcomponent
    @endif

    <div class="o-article__secondary-actions">
        {{-- Intentionally left blank for layout --}}
    </div>

    @if ($item->heading)
    <div class="o-article__intro">
      @component('components.blocks._text')
          @slot('font', 'f-body-editorial')
          @slot('tag', 'div')
          {!! $item->present()->heading !!}
      @endcomponent
    </div>
    @endif

    <div class="o-article__body o-blocks o-blocks--with-sidebar {{ $item->type != \App\Models\DigitalPublicationSection::TEXT ? "o-article__body--no-top-border f-body" : "" }}">
        @if ($item->type == \App\Models\DigitalPublicationSection::TEXT)
            @if ($item->showAuthorsWithLinks())
                @component('components.blocks._text')
                    @slot('font', 'f-tag-2')
                    @slot('variation', 'author-links')
                    @slot('tag', 'div')
                    {!! $item->showAuthorsWithLinks() !!}
                @endcomponent
            @endif
        @endif

        @php
        if ($item->type == \App\Models\DigitalPublicationSection::TEXT) {
            global $_collectedReferences;
            $_collectedReferences = [];

            global $_paragraphCount;
            $_paragraphCount = 0;

            global $_figureCount;
            $_figureCount = 0;
        }

        if ($item->type == \App\Models\DigitalPublicationSection::WORK) {
            global $_figureCount;
            $_figureCount = 0;

            global $_figurePrefixForId;
            $_figurePrefixForId = 'cat-';

            global $_figurePrefixForDisplay;
            $_figurePrefixForDisplay = 'Cat.';
        }

        global $_addHeadingIds;
        $_addHeadingIds = true;

        global $_allowAdvancedModalFeatures;
        $_allowAdvancedModalFeatures = true;

        @endphp

        {!! $item->renderBlocks(false, [], [
            'pageTitle' => $item->meta_title ?: $item->title,
        ]) !!}

        @if (isset($_collectedReferences) && sizeof($_collectedReferences))
            <hr class="hr">
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--no-hr',
                'titleFont' => 'f-list-3'
            ])
                Notes
            @endcomponent
            <div class="o-blocks o-blocks--bibliographic">
                @component('components.blocks._blocks')
                    @slot('blocks',
                        [
                            [
                                'type' => 'references',
                                'items' => $_collectedReferences
                            ]
                        ])
                @endcomponent
            </div>
        @endif

        @if ($item->references)
            <hr class="hr">
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--no-hr',
                'titleFont' => 'f-list-3'
            ])
                References
            @endcomponent
            <div class="o-blocks o-blocks--bibliographic">
                {!! $item->present()->references !!}
            </div>
        @endif

        @if ($item->cite_as)
            <hr class="hr">
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--no-hr',
                'titleFont' => 'f-list-3'
            ])
                How to Cite
            @endcomponent
            <div class="o-blocks o-blocks--bibliographic">
                {!! $item->present()->citeAs !!}
            </div>
        @endif
    </div>
</article>

@endsection
