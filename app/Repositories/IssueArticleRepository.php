<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use App\Repositories\Behaviors\HandleApiBlocks;
use App\Repositories\Behaviors\HandleAuthors;
use App\Jobs\GeneratePdf;
use App\Models\IssueArticle;

class IssueArticleRepository extends ModuleRepository
{
    use HandleSlugs, HandleMedias, HandleRevisions, HandleBlocks, HandleAuthors, HandleApiBlocks {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(IssueArticle $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        parent::afterSave($object, $fields);
        GeneratePdf::dispatch($object);
    }
}
