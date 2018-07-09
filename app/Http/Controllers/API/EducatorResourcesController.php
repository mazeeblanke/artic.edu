<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EducatorResourcesController extends BaseController
{
    protected $model = \App\Models\EducatorResource::class;
    protected $transformer = \App\Http\Transformers\EducatorResourceTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
