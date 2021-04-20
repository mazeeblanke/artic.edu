<div class="o-fullscreen-image" id="fullscreenImage" data-behavior="imageZoomArea">
    <a class="o-fullscreen-image__info-link">Learn more</a>
    @component('components.molecules._m-info-trigger')
        @slot('creditText', 'Lorem ipsum')
    @endcomponent
    <img class="o-fullscreen-image__img" alt="" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=">
    <div class="o-fullscreen-image__osd" id="openseadragon"></div>
    <h2 class="sr-only" id="h-img_action">Image actions</h2>
    <ul class="o-fullscreen-image__img-actions" aria-labelledby="h-img_action">
      <li>
        @component('components.atoms._btn')
            @slot('variation', 'btn--septenary btn--icon-sq')
            @slot('font', '')
            @slot('icon', 'icon--zoom-in--24')
            @slot('id','osd_zoomInButton')
            @slot('dataAttributes', 'data-fullscreen-zoom-in')
            @slot('ariaLabel', 'Zoom in')
        @endcomponent
      </li>
      <li>
        @component('components.atoms._btn')
            @slot('variation', 'btn--septenary btn--icon-sq')
            @slot('font', '')
            @slot('icon', 'icon--zoom-out--24')
            @slot('id','osd_zoomOutButton')
            @slot('dataAttributes', 'data-fullscreen-zoom-out')
            @slot('ariaLabel', 'Zoom out')
        @endcomponent
      </li>
    </ul>
    @component('components.atoms._btn')
        @slot('variation', 'btn--octonary btn--icon btn--icon-circle-48 o-fullscreen-image__close')
        @slot('font', '')
        @slot('icon', 'icon--close--24')
        @slot('dataAttributes', 'data-fullscreen-close')
        @slot('ariaLabel', 'Close full screen image viewer')
    @endcomponent
</div>
