@extends('cms-toolkit::layouts.resources.index', [
    'title' => 'Tag',
    'create' => true,
    'publish' => false,
    'edit' => true,
    'delete' => true,
    'search' => true,
    'columns' => [
        'name' => [
            'title' => 'Name',
            'edit_link' => true,
            'field' => 'name',
        ]
    ]
])
