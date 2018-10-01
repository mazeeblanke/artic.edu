<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\Api\ExhibitionRepository;
use App\Repositories\SiteTagRepository;

class ExhibitionController extends BaseApiController
{
    protected $moduleName = 'exhibitions';
    protected $hasAugmentedModel = true;
    protected $previewView = 'site.exhibitionDetail';

    protected $indexOptions = [
        'publish' => false,
        'bulkEdit' => false,
        'create' => false,
        'permalink' => true,
    ];

    protected $indexColumns = [
        'image' => [
            'thumb' => true,
            'optional' => false,
            'variant' => [
                'role' => 'hero',
                'crop' => 'default',
            ],
        ],
        'title' => [
            'title' => 'Title',
            'field' => 'title',
            'sort' => true,
        ],
        'augmented' => [
            'title' => 'Augmented?',
            'field' => 'augmented',
            'present' => true,
        ],
        'date' => [
            'title' => 'Dates',
            'field' => 'date',
            'present' => true,
            'optional' => false,
        ],
    ];

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'siteTags'];

    protected $defaultOrders = ['title' => 'desc'];

    protected $filters = [];

    protected function orderScope()
    {
        // Use the default order scope from Twill.
        // Added this as an exception on exhibitions because it's the only API listing that
        // sorting has been implemented. See the scope on Models\Api\Exhibition
        return ModuleController::orderScope();
    }

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('exhibition') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/exhibitions/' . $item->datahub_id . '/';

        return [
            'siteTagsList' => app(SiteTagRepository::class)->listAll('name'),
            'exhibitionTypesList' => $this->repository->getExhibitionTypesList(),
            'editableTitle' => false,
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        // The ID is a datahub_id not a local ID
        $apiRepo = app(ExhibitionRepository::class);
        $apiItem = $apiRepo->getById($item->datahub_id);

        // Force the augmented model
        $apiItem->setAugmentedModel($item);

        return $apiRepo->getShowData($apiItem);
    }

}
