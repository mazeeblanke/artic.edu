@extends('cms-toolkit::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'attributes', 'label' => 'Attributes'],
        ['fieldset' => 'related', 'label' => 'Related'],
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related'],
        ['fieldset' => 'api', 'label' => 'Datahub fields'],
    ]
])


@section('contentFields')
    @formField('checkbox', [
        'name' => 'is_visible',
        'label' => 'Visible?',
    ])

    @formField('select', [
        'name' => 'cms_exhibition_type',
        'label' => 'Exhibition layout',
        'options' => $exhibitionTypesList,
        'default' => '0'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero image',
        'name' => 'hero'
    ])

    @formField('input', [
        'name' => 'header_copy',
        'label' => 'Header',
    ])

    @formField('input', [
        'name' => 'list_description',
        'label' => 'List description',
        'type' => 'textarea'
    ])

    @formField('wysiwyg', [
        'name' => 'exhibition_message',
        'label' => 'Pricing or attendance information',
        'toolbarOptions' => ['bold']
    ])

    @formField('input', [
        'name' => 'sponsors_description',
        'label' => 'Sponsors section description',
        'type' => 'textarea'
    ])

    @formField('input', [
        'name' => 'sponsors_sub_copy',
        'label' => 'Sponsors sub copy',
        'note' => 'E.G. further support provided by'
    ])

    @formField('browser', [
        'routePrefix' => 'exhibitions_events',
        'moduleName' => 'sponsors',
        'name' => 'sponsors',
        'label' => 'Sponsors',
        'note' => 'Select sponsors',
        'max' => 20
    ])

    @formField('block_editor', [
        'blocks' => [
            'event', 'paragraph', 'image', 'video', 'gallery',
            'media_embed', 'quote', 'list', 'accordion', 'newsletter_signup_inline',
            'shop_items', 'timeline', 'link'
        ]
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="attributes" title="Attributes">
        @formField('input', [
            'name' => 'datahub_id',
            'label' => 'Datahub ID',
            'disabled' => true
        ])

        @formField('multi_select', [
            'name' => 'siteTags',
            'label' => 'Tags',
            'options' => $siteTagsList,
            'placeholder' => 'Select some tags',
        ])
    </a17-fieldset>
    <a17-fieldset id="related" title="Related">
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 4,
            'name' => 'exhibitions',
            'label' => 'Related exhibitions'
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'events',
            'name' => 'events',
            'label' => 'Related events',
            'note' => 'Select related events',
            'max' => 20
        ])
    </a17-fieldset>

    <a17-fieldset id="side_related" title="Sidebar Related - Only one will show up randomly">
        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'videos',
            'max' => 1,
            'name' => 'videos',
            'label' => 'Related video'
        ])

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'articles',
            'max' => 1,
            'name' => 'articles',
            'label' => 'Related article',
        ])
    </a17-fieldset>

    <a17-fieldset id="api" title="Datahub fields">
        @formField('input', [
            'name' => 'title',
            'label' => 'Title',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'description',
            'label' => 'Description',
            'type' => 'textarea',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'short_description',
            'label' => 'Short description',
            'type' => 'textarea',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'start_at',
            'label' => 'Start at',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'end_at',
            'label' => 'End at',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'status',
            'label' => 'Status',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'lake_guid',
            'label' => 'Lake GUID',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'department_title',
            'label' => 'Department',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'department_id',
            'label' => 'Department ID',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'gallery_title',
            'label' => 'Gallery',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'gallery_id',
            'label' => 'Gallery ID',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'type',
            'label' => 'Type',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'last_updated',
            'label' => 'Last updated',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'artwork_ids',
            'label' => 'Artwork IDs',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'venue_ids',
            'label' => 'Venue IDs',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'site_ids',
            'label' => 'Site IDs',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'event_ids',
            'label' => 'Event IDs',
            'disabled' => true
        ])
    </a17-fieldset>
@stop
