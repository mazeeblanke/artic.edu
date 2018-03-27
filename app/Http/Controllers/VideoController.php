<?php

namespace App\Http\Controllers;

use App\Repositories\VideoRepository;
use App\Models\Page;
use App\Models\Video;

class VideoController extends FrontController
{
    protected $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function show($slug)
    {
        $item = $this->repository->forSlug($slug);
        if (empty($item)) {
            $item = $this->repository->getById($slug);
        }

        $item->type  = 'embed';
        $item->media = array('embed' => \EmbedConverter::convertUrl($item->video_url));

        $relatedVideos = Video::published()->limit(4)->whereNotIn('id', array($item['id']))->get();

        return view('site.videoDetail', [
            'item' => $item,
            'relatedVideos' => $relatedVideos
        ]);
    }

}
