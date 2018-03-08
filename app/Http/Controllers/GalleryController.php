<?php

namespace App\Http\Controllers;

use App\Repositories\Api\GalleryRepository;
use App\Models\Api\Gallery;
use App\Models\Api\Search;
use Carbon\Carbon;

class GalleryController extends FrontController
{
    protected $repository;

    public function __construct(GalleryRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function show($id)
    {
        // The ID is a datahub_id not a local ID
        $item = $this->repository->getById($id);
        $artworks = Search::query()->resources(['artworks'])->byGallery($item->id)->getSearch();

        return view('site.tagDetail', [
            'item' => $item,
            'artworks' => $artworks
        ]);
    }

}
