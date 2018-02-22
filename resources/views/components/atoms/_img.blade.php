@php
    if (isset($image_id)) {
        $src = LakeviewImageService::getUrl($image_id);
    }

    if (isset($settings)) {
        $settings = aic_imageSettings(array(
            'settings' => $settings,
            'image' => $image,
        ));

        $srcset = $settings['srcset'];
        $sizes = $settings['sizes'];
        $src = $settings['src'];
        $width = $settings['width'];
        $height = $settings['height'];
    }

    if (empty($src)) {
        $src = $image['src'];
    }

    if (empty($width)) {
        $width = $image['width'];
    }

    if (empty($height)) {
        $height = $image['height'];
    }
@endphp
<img
    alt="{{ $image['alt'] ?? '' }}{{ $alt ?? '' }}"
    class="{{ $image['class'] ?? '' }} {{ $class ?? '' }}"
    src="{{ $src ?? '' }}"
    srcset="{{ $srcset ?? '' }}"
    sizes="{{ $sizes ?? '' }}"
    width="{{ $width ?? '' }}"
    height="{{ $height ?? '' }}"
>
