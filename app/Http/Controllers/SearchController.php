<?php

namespace App\Http\Controllers;

use App\Models\Api\Artwork;
use App\Models\Api\Artist;
use App\Models\Api\Search as GeneralSearch;
use App\Models\Api\Exhibition;

use App\Repositories\Api\ArtworkRepository;
use App\Repositories\Api\ArtistRepository;
use App\Repositories\Api\SearchRepository;
use App\Repositories\Api\ExhibitionRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\PublicationsRepository;
use App\Repositories\EventRepository;

use App\Http\Controllers\StaticsController;

use App\Libraries\Search\CollectionService;

use LakeviewImageService;

class SearchController extends BaseScopedController
{
    const ALL_PER_PAGE = 5;
    const ALL_PER_PAGE_ARTWORKS = 8;
    const ALL_PER_PAGE_EXHIBITIONS = 4;
    const ALL_PER_PAGE_EVENTS = 4;
    const ALL_PER_PAGE_ARTICLES = 4;

    const ARTWORKS_PER_PAGE = 20;
    const EXHIBITIONS_PER_PAGE = 20;
    const ARTISTS_PER_PAGE = 30;
    const AUTOCOMPLETE_PER_PAGE = 10;

    protected $artworksRepository;
    protected $artistsRepository;
    protected $searchRepository;
    protected $exhibitionsRepository;
    protected $articlesRepository;

    public function __construct(
        ArtworkRepository $artworks,
        ArtistRepository $artists,
        SearchRepository $search,
        ExhibitionRepository $exhibitions,
        ArticleRepository $articles,
        PublicationsRepository $publications,
        EventRepository $events
    ) {
        $this->artworksRepository = $artworks;
        $this->artistsRepository = $artists;
        $this->searchRepository = $search;
        $this->exhibitionsRepository = $exhibitions;
        $this->articlesRepository = $articles;
        $this->eventsRepository = $events;
        $this->publicationsRepository = $publications;

        parent::__construct();
    }


    public function index()
    {
        $this->seo->setTitle('Search');

        // General search to get featured elements and general metadata.
        $general = $this->searchRepository->forSearchQuery(request('q'), 0);
        $links = $this->buildSearchLinks($general, 'all');

        // Specific elements search. We run separate queries because we want to ensure elements
        // in all sections. A general search sorting might cause empty categories.
        $publications = $this->publicationsRepository->searchApi(request('q'), self::ALL_PER_PAGE_ARTICLES);
        $articles     = $this->articlesRepository->searchApi(request('q'), self::ALL_PER_PAGE_ARTICLES);
        $artworks     = $this->collection()->perPage(self::ALL_PER_PAGE_ARTWORKS)->results();
        $artists      = $this->artistsRepository->forSearchQuery(request('q'), self::ALL_PER_PAGE);
        $exhibitions  = $this->exhibitionsRepository->searchApi(request('q'), self::ALL_PER_PAGE_EXHIBITIONS);
        $events       = $this->eventsRepository->searchApi(request('q'), self::ALL_PER_PAGE_EVENTS);

        return view('site.search.index', [
            'featuredResults' => $general->where('is_boosted', true),
            'artworks' => $artworks,
            'artists'  => $artists,
            'articles' => $articles,
            'events'   => $events,
            'exhibitions'  => $exhibitions,
            'publications' => $publications,
            'allResultsView' => false,
            'searchResultsTypeLinks' => $links
        ]);
    }

    public function autocomplete()
    {
        $collection = GeneralSearch::search(request('q'))
            ->resources(['artworks', 'exhibitions', 'artists', 'agents', 'events', 'articles', 'digital-catalogs', 'printed-catalogs'])
            ->getSearch(self::AUTOCOMPLETE_PER_PAGE);

        foreach($collection as &$item) {
            switch ((new \ReflectionClass($item))->getShortName()) {
                case 'Artwork':
                    $item->url = route('artworks.show', $item);
                    $item->section = 'Artworks';
                    break;
                case 'Exhibition':
                    $item->url = route('exhibitions.show', $item);
                    $item->section = 'Exhibitions and Events';
                    break;
                case 'Artist':
                    $item->url = route('artists.show', $item);
                    $item->section = 'Artists';
                    break;
                case 'Event':
                    $item->url = route('events.show', $item);
                    $item->section = 'Events';
                    break;
                case 'Article':
                    $item->url = route('articles.show', $item);
                    $item->section = 'Articles';
                    break;
                case 'DigitalCatalog':
                    $item->url = route('collection.publications.digital-catalogs.show', $item);
                    $item->section = 'Digital Catalogs';
                    break;
                case 'PrintedCatalog':
                    $item->url = route('collection.publications.printed-catalogs.show', $item);
                    $item->section = 'Printed Catalogs';
                    break;
            }

            $item->text = $item->title;
        }

        return view('partials/_autocomplete', [
            'term' => request('q'),
            'resultCount' => $collection->total(),
            'items' => $collection,
            'seeAllUrl' => route('search', ['q' => request('q')])
        ]);
    }

    public function artworks()
    {
        $this->seo->setTitle('Search');

        $general  = $this->searchRepository->forSearchQuery(request('q'), 2);

        $artworks      = $this->collection()->perPage(self::ARTWORKS_PER_PAGE)->results();
        $filters       = $this->collection()->generateFilters();
        $activeFilters = $this->collection()->activeFilters();

        $links = $this->buildSearchLinks($general, 'artworks');

        return view('site.search.index', [
            'artworks' => $artworks,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
            'filterCategories' => $filters,
            'activeFilters'    => $activeFilters
        ]);
    }

    /**
     * Implementation for BaseScopedController.
     * This is the beginning for the chain of scoped results
     * The remaining scopes are applied following the $scopes
     * array defined at the controller
     *
     */
    protected function beginOfAssociationChain()
    {
        // Define base entity
        $collectionService = new CollectionService;

        // Implement default filters and scopes
        $collectionService->resources(['artworks'])
            ->allAggregations()
            ->forceEndpoint('search');

        return $collectionService;
    }

    public function exhibitions()
    {
        $this->seo->setTitle('Search');

        $general     = $this->searchRepository->forSearchQuery(request('q'), 2);
        $exhibitions = $this->exhibitionsRepository->searchApi(request('q'), self::EXHIBITIONS_PER_PAGE);

        $links = $this->buildSearchLinks($general, 'exhibitions');

        return view('site.search.index', [
            'exhibitions' => $exhibitions,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
        ]);
    }

    public function artists()
    {
        $this->seo->setTitle('Search');

        $general = $this->searchRepository->forSearchQuery(request('q'), 2);
        $artists = $this->artistsRepository->forSearchQuery(request('q'), self::ARTISTS_PER_PAGE);

        $links = $this->buildSearchLinks($general, 'artists');

        return view('site.search.index', [
            'artists' => $artists,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
        ]);
    }

    protected function buildSearchLinks($all, $active = 'all')
    {
        $links = [];
        $aggregations = $all->getMetadata('aggregations')->types->buckets;

        array_push($links, $this->buildLabel('All', $all->getMetadata('pagination')->total, route('search', ['q' => request('q')]), $active == 'all'));

        if (extractAggregation($aggregations, 'agents')) {
            array_push($links, $this->buildLabel('Artist', extractAggregation($aggregations, 'agents'), route('search.artists', ['q' => request('q')]), $active == 'artists'));
        }
        if (extractAggregation($aggregations, 'artworks')) {
            array_push($links, $this->buildLabel('Artwork', extractAggregation($aggregations, 'artworks'), route('search.artworks', ['q' => request('q')]), $active == 'artworks'));
        }
        if (extractAggregation($aggregations, 'exhibitions')) {
            array_push($links, $this->buildLabel('Exhibitions', extractAggregation($aggregations, 'exhibitions'), route('search.exhibitions', ['q' => request('q')]), $active == 'exhibitions'));
        }
        if (extractAggregation($aggregations, 'events')) {
            array_push($links, $this->buildLabel('Events', extractAggregation($aggregations, 'events'), route('events'), $active == 'events'));
        }
        if (extractAggregation($aggregations, 'digital-catalogs')) {
            array_push($links, $this->buildLabel('Digital Catalogs', extractAggregation($aggregations, 'digital-catalogs'), route('collection.publications.digital-catalogs'), $active == 'digital-catalogs'));
        }
        if (extractAggregation($aggregations, 'printed-catalogs')) {
            array_push($links, $this->buildLabel('Printed Catalogs', extractAggregation($aggregations, 'printed-catalogs'), route('collection.publications.printed-catalogs'), $active == 'printed-catalogs'));
        }

        return $links;
    }

    protected function buildLabel($name, $total, $href, $active) {
        return [
            'label' => ($name == 'All' ? 'All' : str_plural($name, $total)) .' ('. $total.')',
            'href' => $href,
            'active' => $active
        ];
    }

}
