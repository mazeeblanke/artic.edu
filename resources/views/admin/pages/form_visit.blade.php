@push('extra_js')
    <script src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_API_KEY') !!}&maptype=roadmap"></script>
    <script src="/assets/admin/behaviors/google_maps.js"></script>
@endpush

<section class="box">
    <header class="header_small">
        <h3><b>Visit</b></h3>
    </header>

    @formField('input', [
        'field' => 'visit_intro',
        'field_name' => 'Intro text',
    ])

    {{-- @formField('medias', [
        'media_role' => 'hero',
        'media_role_name' => 'Hero Image',
        'with_multiple' => false,
        'no_crop' => false
    ]) --}}

</section>

@formField('repeater', [
    'moduleName' => 'admissions',
    'title' => 'Free Admissions',
    'routePrefix' => 'landing.visit',
    'title_singular' => 'Free Admission'
])

<section class="box" data-behavior="google_maps" data-latlng="41.8794774,-87.6222743">
    <header class="header_small">
        <h3><b>Map that will be shown at the FE</b></h3>
    </header>

    <div class="map-canvas"></div>
</section>
