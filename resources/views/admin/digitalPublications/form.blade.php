@extends('twill::layouts.form')

@section('contentFields')
    <br /><strong><a href="{{ url('/collection/articles_publications/digitalPublications/' . $item->id . '/sections') }}">{{ $item->sections->count() }} Sections</a></strong>
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Banner image',
        'name' => 'banner',
        'note' => 'Minimum image width 2000px'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Listing image',
        'name' => 'listing',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('wysiwyg', [
        'name' => 'listing_description',
        'label' => 'Listing description',
        'maxlength'  => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic'
        ],
    ])

{{--
    DEPRECATED: This field is null for all existing publications.
    Use listing_description instead.
--}}
{{--
    @formField('input', [
        'name' => 'short_description',
        'label' => 'Short description',
        'type' => 'textarea',
        'maxlength' => 255
    ])
--}}

{{--
    DEPRECATED: This field hasn't been filled out for any publications
    that have been added since the website launched. It's not used for
    sorting, or displayed on the frontend.
--}}
{{--
    @formField('input', [
        'name' => 'publication_year',
        'label' => 'Publication year',
    ])
--}}

    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            'paragraph', 'image', 'video', 'media_embed', 'list',
            'accordion', 'membership_banner', 'timeline', 'link', 'newsletter_signup_inline',
            'hr', 'split_block', '3d_model'
        ])
    ])
@stop

@section('fieldsets')

    @include('admin.partials.related')

    @include('admin.partials.meta')

@endsection
