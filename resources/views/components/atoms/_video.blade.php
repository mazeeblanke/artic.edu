<video src="{{ $src ?? '' }}" poster="{{ $poster ?? '' }}"{{ isset($autoplay) ? ' autoplay' : '' }}{{ isset($loop) ? ' loop' : '' }}{{ isset($muted) ? ' muted' : '' }}{{ isset($preload) ? ' preload' : '' }}{{ isset($controls) ? ' controls="'.$controls.'"' : '' }}></video>
