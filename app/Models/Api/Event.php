<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Event extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/events',
        'resource'   => '/api/v1/events/{id}',
        'search'     => '/api/v1/events/search'
    ];

    // TODO:
    // Include an augmented model and bypass not found functions to it.
}
