@php
    $subtype = $block->input('layout') == 1 ? 'mosaic' : 'slider';

    $items = [];

    foreach ($block->childs as $item) {
        switch ($item->input('gallery_item_type')) {
            case \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_CUSTOM:
                $title = $item->present()->input('captionTitle');
                $subtitle = $item->present()->input('captionText');

                $items[] = [
                    'type' => 'image',
                    'size' => 'gallery',
                    'fullscreen' => true,
                    'media' => $item->imageAsArray('image', 'desktop'),
                    'captionTitle' => getTitleWithFigureNumber($title),
                    'caption' => getSubtitleWithFigureNumber($subtitle, $title),
                ];

                break;
            case \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_ARTWORK:
                // TODO: Preload all artworks ahead of time
                $ids = $item->browserIds('artwork');
                $artworks = \App\Models\Api\Artwork::query()->ids($ids)->get();
                $artwork = $artworks[0];

                if (!$artwork) {
                  break;
                }

                $image = $artwork->imageFront('hero', 'thumbnail');
                $title = $artwork->present()->listingTitle;

                $caption = '';

                if (!empty($artwork->artist_title)) {
                    $caption = '<p>' . $artwork->present()->artist_title . '</p>';
                } else if (!empty($artwork->place_of_origin)) {
                    $caption = '<p>' . $artwork->present()->place_of_origin . '</p>';
                }

                if (!empty($item->input('captionAddenum'))) {
                    $caption .= $item->input('captionAddenum');
                }

                $items[] = [
                  'type' => 'image',
                  'fullscreen' => true,
                  'size' => 'gallery',
                  'media' => $image,
                  'captionTitle' => getTitleWithFigureNumber($title),
                  'caption' => getSubtitleWithFigureNumber($caption, $title),
                  'url' => route('artworks.show', $artwork),
                  'urlTitle' => route('artworks.show', $artwork),
                  'showUrl' => true,
                  'isArtwork' => true,
                  'isZoomable' => $artwork->is_zoomable,
                  'isPublicDomain' => $artwork->is_public_domain,
                  'maxZoomWindowSize' => $artwork->max_zoom_window_size,
                ];
                break;
        }
    }
@endphp

@if (count($items) > 0)
  @component('components.organisms._o-gallery----'.$subtype)
      @if ($subtype === 'mosaic')
          @slot('imageSettings', array(
              'srcset' => array(200,400,600,1000,1500,3000,4500),
              'sizes' => aic_imageSizes(array(
                    'xsmall' => '58',
                    'small' => '28',
                    'medium' => '28',
                    'large' => '28',
                    'xlarge' => '21',
              )),
          ))
      @endif
      @if ($subtype === 'slider')
          @slot('imageSettings', array(
              'srcset' => array(200,400,600,1000,1500,3000,4500),
              'sizes' => aic_imageSizes(array(
                    'xsmall' => '50',
                    'small' => '35',
                    'medium' => '23',
                    'large' => '23',
                    'xlarge' => '18',
              )),
          ))
      @endif

      @slot('variation', 'o-blocks__block o-gallery----theme-' . ($block->input('theme') ?? 'dark'))
      @slot('title', $block->present()->input('title'))
      @slot('caption', $block->present()->input('description'))
      @slot('allLink', null);
      @slot('items', $items)
  @endcomponent
@endif
