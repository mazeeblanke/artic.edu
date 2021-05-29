@twillBlockTitle('Artworks gallery (old)')
@twillBlockIcon('image')
@twillBlockComponent('a17-block-artworks')

<p style="color: red">This block is deprecated. Its content will be migrated in a future release. Please use "Gallery (new)" for new content.</p>

@formField('browser', [
    'routePrefix' => 'collection',
    'name' => 'artworks',
    'moduleName' => 'artworks',
    'label' => 'Artworks',
    'max' => 100
])

@include('admin.partials.gallery-shared')

@formField('input', [
    'name' => 'title',
    'label' => 'Gallery Title',
    'maxlength' => 150
])

@formField('input', [
    'name' => 'subhead',
    'label' => 'Image Subhead',
    'note' => 'Will be hidden if title is empty',
])
