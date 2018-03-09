<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleBlocks;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\HomeFeature;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;

use App\Repositories\Api\BaseApiRepository;

class HomeFeatureRepository extends ModuleRepository
{
    use  HandleMedias, HandleBLocks, HandleApiBlocks, HandleApiRelations {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(HomeFeature $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateBrowser($object, $fields, 'articles');
        $this->updateBrowser($object, $fields, 'events');
        $this->updateBrowserApiRelated($object, $fields, ['artworks', 'exhibitions']);
        // $this->updateBrowserApiRelated($object, $fields, ['exhibitions']);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['events'] = $this->getFormFieldsForBrowser($object, 'events', 'whatson');
        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'whatson');
        $fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitions', 'App\Models\Api\Exhibition', 'whatson');
        $fields['browsers']['artworks'] = $this->getFormFieldsForBrowserApi($object, 'artworks', 'App\Models\Api\Artwork', 'whatson');

        return $fields;
    }

}
