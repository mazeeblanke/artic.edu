<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Repositories\Behaviors\HandleApiRelations;

abstract class BaseApiRepository extends ModuleRepository
{
    use HandleApiRelations;

    public function filter($query, array $scopes = [])
    {
        // Perform a search first and then filter.
        // Because endpoints are different is preferable to acknoledge a search before
        // computing the rest of the filters
        $this->searchIn($query, $scopes, 'search', []);

        return parent::filter($query, $scopes);
    }

    public function searchIn($query, &$scopes, $scopeField, $orFields = [])
    {
        if (isset($scopes[$scopeField]) && is_string($scopes[$scopeField])) {
            $query->search($scopes[$scopeField]);
            unset($scopes[$scopeField]);
        }
    }

    public function forSearchQuery($string, $perPage = null, $columns = [], $pageName = 'page', $page = null )
    {
        // Build the search query
        $search  = $this->model->search($string);

        // Perform the query
        $results = $search->getSearch($perPage, $columns, $pageName, $page);

        // Build metadata and results
        return [
            'pagination'   => $search->paginationData,
            'aggregations' => $search->aggregationsData,
            'suggestions'  => $search->suggestionsData,
            'items'        => $results
        ];
    }

}
