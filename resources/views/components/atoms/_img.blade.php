@php
    $highlight = ' ';

    if (isset($settings)) {
        $settings = aic_imageSettings(array(
            'settings' => $settings,
            'image' => $image,
        ));

        $srcset = $settings['srcset'];
        $sizes = $settings['sizes'];
        $src = $settings['lqip'] ?? $settings['src'];
        $width = $settings['width'];
        $height = $settings['height'];
    }

    if (empty($srcset) && empty($src)) {
        $highlight = ' data-no-img-settings';
    }

    if (empty($src) && isset($image['src'])) {
        $src = $image['src'];
    }

    if (empty($width) && isset($image['width'])) {
        $width = $image['width'];
    }

    if (empty($height) && isset($image['height'])) {
        $height = $image['height'];
    }
@endphp
<img
    alt="{{ $image['alt'] ?? '' }}{{ $alt ?? '' }}"
    class="{{ $image['class'] ?? '' }} {{ $class ?? '' }}"
    @if (empty($srcset) and isset($src))
        data-src="{{ $src ?? '' }}"
    @else
        src="{{ $src ?? '' }}"
    @endif
    @if (isset($_GET['print']) or (isset($settings['lazyload']) and $settings['lazyload'] === false))
    srcset="{{ $srcset ?? '' }}"
    @else
    data-srcset="{{ $srcset ?? '' }}"
    @endif
    sizes="{{ $sizes ?? '' }}"
    width="{{ $width ?? '' }}"
    height="{{ $height ?? '' }}"
    {{ $highlight }}
>
