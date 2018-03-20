@extends('layouts.app')

@section('content')

@component('components.atoms._title')
    @slot('tag','p')
    @slot('font','f-display-2')
    Listings
@endcomponent

@component('components.atoms._hr')
@endcomponent


@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Explore the shop', 'href' => '#')))
    5 column scroll
@endcomponent
@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
    @slot('cols_medium','4')
    @slot('cols_large','5')
    @slot('cols_xlarge','5')
    @slot('behavior','dragScroll')
    @foreach ($products as $item)
        @component('components.molecules._m-listing----product')
            @slot('item', $item)
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Browse events', 'href' => '#')))
    4 column stacked
@endcomponent
@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','4')
    @slot('cols_xlarge','4')
    @foreach ($exhibitions8 as $item)
        @component('components.molecules._m-listing----exhibition')
            @slot('item', $item)
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Explore the shop', 'href' => '#')))
    4 column scroll
@endcomponent
@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
    @slot('cols_medium','3')
    @slot('cols_large','4')
    @slot('cols_xlarge','4')
    @slot('behavior','dragScroll')
    @foreach ($exhibitions4 as $item)
        @component('components.molecules._m-listing----exhibition')
            @slot('item', $item)
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Browse events', 'href' => '#')))
    3 column stacked
@endcomponent
@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','3')
    @slot('cols_xlarge','3')
    @foreach ($exhibitions6 as $item)
        @component('components.molecules._m-listing----exhibition')
            @slot('item', $item)
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Browse events', 'href' => '#')))
    3 column list
@endcomponent
@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_large','3')
    @slot('cols_xlarge','3')
    @foreach ($exhibitions3 as $item)
        @component('components.molecules._m-listing----exhibition')
            @slot('variation', 'm-listing--row@small m-listing--row@medium')
            @slot('item', $item)
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Browse events', 'href' => '#')))
    2 column stacked
@endcomponent
@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','2')
    @slot('cols_large','2')
    @slot('cols_xlarge','2')
    @foreach ($exhibitions4 as $item)
        @component('components.molecules._m-listing----exhibition')
            @slot('item', $item)
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Upcoming events', 'href' => '#')))
    Date listing
@endcomponent
@component('components.organisms._o-row-listing')
    @foreach ($eventsByDay as $date => $events)
        @component('components.molecules._m-date-listing')
            @slot('date', $date)
            @slot('events', $events)
            @slot('imageSettings', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(200,400,600),
                'sizes' => aic_imageSizes(array(
                      'xsmall' => '58',
                      'small' => '13',
                      'medium' => '13',
                      'large' => '13',
                      'xlarge' => '13',
                )),
            ))
            @slot('imageSettingsOnGoing', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(200,400,600),
                'sizes' => aic_imageSizes(array(
                      'xsmall' => '58',
                      'small' => '7',
                      'medium' => '7',
                      'large' => '7',
                      'xlarge' => '7',
                )),
            ))
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Browse events', 'href' => '#')))
    Row listing
@endcomponent
@component('components.organisms._o-row-listing')
    @foreach ($exhibitions4 as $item)
        @component('components.molecules._m-listing----exhibition-row')
            @slot('variation', 'm-listing--inline')
            @slot('item', $item)
        @endcomponent
    @endforeach
@endcomponent

@endsection
