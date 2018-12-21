<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Models\Page;
use App\Models\Article;
use App\Models\Api\DigitalLabel;

class ArticleController extends FrontController
{
    const ARTICLES_PER_PAGE = 12;
    protected $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index()
    {
        $this->seo->setTitle('Articles');

        $page = Page::forType('Articles')->with('articlesArticles')->first();
        $heroArticle = $page->articlesArticles->first();
        
        $articles = new \Illuminate\Pagination\LengthAwarePaginator(collect(), 0, self::ARTICLES_PER_PAGE);

        if (request('category') !== 'digital-labels') {
            $articles = Article::published()
                ->byCategory(request('category'))
                ->whereNotIn('id', $page->articlesArticles->pluck('id'))
                ->orderBy('date', 'desc')
                ->paginate(self::ARTICLES_PER_PAGE);
            
        } else {
            // Retrieve digital label entires
            $articles = DigitalLabel::query()->getPaginatedModel(self::ARTICLES_PER_PAGE, \App\Models\Api\DigitalLabel::SEARCH_FIELDS);
        }
        
        // $digitaLabels = DigitalLabel::published()
            // ->whereNotIn('id', $page->digitalLabels->pluck('id'));
            // ->orderBy('date', 'desc')
            // ->paginate(self::ARTICLES_PER_PAGE);

        // Featured articles are the selected ones if no filters are applied
        // otherwise those are just the first two from the collection
        if (empty(request()->get('category', null))) {
            $featuredArticles = $page->articlesArticles->slice(1, 2);
        } else {
            $featuredArticles = $articles->getCollection()->slice(0, 2);
            $newCollection = $articles->slice(2);

            // Replace pagination collection with
            $articles->setCollection($newCollection);
        }

        // These should be moved away from the controller.
        $categories = [
            [
                'label' => 'All',
                'href' => route('articles'),
                'active' => empty(request()->all()),
                'ajaxScrollTarget' => 'listing',
            ]
        ];

        foreach ($page->articlesCategories as $category) {
            array_push($categories,
                [
                    'label'  => $category->name,
                    'href'   => route('articles', ['category' => $category->id]),
                    'active' => request()->get('category') == $category->id,
                    'ajaxScrollTarget' => 'listing',
                ]
            );
        }

        array_push($categories,
            [
                'label' => 'Digital Labels',
                'href' => route('articles', ['category' => 'digital-labels']),
                'active' => empty(request()->all()),
                'ajaxScrollTarget' => 'listing',
            ]
        );


        return view('site.articles', [
            'primaryNavCurrent' => 'collection',
            'page' => $page,
            'heroArticle' => $heroArticle,
            'articles' => $articles,
            'categories' => $categories,
            'featuredArticles' => $featuredArticles
        ]);
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->published()->find((Integer) $id);

        if (!$item) {
            abort(404);
        }

        // Redirect to the canonical page if it wasn't requested
        $canonicalPath = route('articles.show', ['id' => $item->id, 'slug' => $item->getSlug()], false);
        if ('/' .request()->path() != $canonicalPath) {
            return redirect($canonicalPath, 301);
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->heading ?: truncateStr(strip_tags($item->present()->copy()), 297));
        $this->seo->setImage($item->imageFront('hero'));

        if ($item->categories->first()) {
            $item->topics = $item->categories;
        }

        return view('site.articleDetail', [
            'contrastHeader' => $item->present()->contrastHeader,
            'item' => $item,
            'canonicalUrl' => route('articles.show', ['id' => $item->id, 'slug' => $item->getSlug()]),
        ]);
    }
}
