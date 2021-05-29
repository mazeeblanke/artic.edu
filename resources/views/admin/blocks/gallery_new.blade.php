@twillBlockTitle('Gallery (new)')
@twillBlockIcon('image')
@twillBlockComponent('a17-block-gallery_new')

{{-- WEB-1251: After removing the old `gallery` and `artworks` blocks, inline contents partial --}}
@include('admin.partials.gallery-shared')

@formField('input', [
    'name' => 'title',
    'label' => 'Title',
    'maxlength' => 60
])

@formField('input', [
    'type' => 'textarea',
    'name' => 'description',
    'label' => 'Description',
    'rows' => 4,
    'maxlength' => 500,
    'note' => 'Will be hidden if title is empty',
])

@formField('checkbox', [
    'name' => 'disable_gallery_modals',
    'label' => 'Disable modals for this gallery',
])

@formField('checkbox', [
    'name' => 'is_gallery_zoomable',
    'label' => 'Make all image modals zoomable (override)',
])

@formField('repeater', [
    'type' => 'gallery_new_item',
])
