@extends('twill::layouts.form')

@section('contentFields')
    @formField('radios', [
        'name' => 'asset_type',
        'label' => 'Asset Type',
        'default' => 'standard',
        'inline' => true,
        'options' => [
            [
                'value' => 'standard',
                'label' => 'Standard'
            ],
            [
                'value' => 'seamless',
                'label' => 'Seamless'
            ],
        ]
    ])

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'asset_type',
        'fieldValues' => 'seamless',
        'renderForBlocks' => false
    ])
        @formField('radios', [
            'name' => 'media_type',
            'label' => 'Media Type',
            'default' => 'image',
            'inline' => true,
            'options' => [
                [
                    'value' => 'type_image',
                    'label' => 'Image'
                ],
                [
                    'value' => 'type_sequence',
                    'label' => 'Sequence'
                ],
            ]
        ])
        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'media_type',
            'fieldValues' => 'type_image',
            'renderForBlocks' => false
        ])
            @formField('medias', [
                'name' => 'image',
                'label' => 'Image',
                'max' => 1,
            ])
        @endcomponent

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'media_type',
            'fieldValues' => 'type_sequence',
            'renderForBlocks' => false
        ])
            @formField('files', [
                'name' => 'sequence_file',
                'label' => 'Sequence zip file',
                'noTranslate' => true,
                'max' => 1,
            ])
        @endcomponent

        @formField('input', [
            'name' => 'media_title',
            'label' => 'Media Title'
        ])
    @endcomponent

    @formField('select', [
        'name' => 'module_type',
        'label' => 'Module Type',
        'placeholder' => 'Select a type',
        'options' => [
            [
                'value' => 'split',
                'label' => 'Split'
            ],
            [
                'value' => 'interstitial',
                'label' => 'Interstitial'
            ],
            [
                'value' => 'tooltip',
                'label' => 'Tooltip'
            ],
            [
                'value' => 'full-width-media',
                'label' => 'Full-Width Media'
            ],
            [
                'value' => 'compare',
                'label' => 'Compare'
            ],
        ]
    ])
@stop