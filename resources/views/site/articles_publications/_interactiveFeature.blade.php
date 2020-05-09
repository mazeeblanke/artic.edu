<section>
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'Browse all interactive features', 'href' => route('interactiveFeatures'))))
        Interactive Features
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @foreach ($experiences as $item)
            @component('components.molecules._m-listing----experience')
                @slot('variation', 'm-listing--row@small m-listing--row@medium')
                @slot('item', $item)
                @slot('image', $item->imageFront('hero') ?? null)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                        'xsmall' => '58',
                        'small' => '23',
                        'medium' => '22',
                        'large' => '18',
                        'xlarge' => '18',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent

    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--title-bar-companion')
        @slot('linksPrimary', array(
            array(
                'label' => 'Browse all interactive features',
                'href' => route('interactiveFeatures'),
                'variation' => 'btn btn--secondary'
            ),
        ))
    @endcomponent
</section>
