<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\PageRepository;
use App\Repositories\ExhibitionRepository;
use App\Repositories\EventRepository;
use Session;

class PageController extends ModuleController
{
    protected $moduleName = 'pages';
    protected $breadcrumb = false;
    protected $formWith = ['slugs'];
    protected $formWithCount = [];

    protected function formData($request)
    {
        return [
            'with_revisions' => false,
        ];
    }

    public function home(PageRepository $pages)
    {
        abort_unless($homepage = $pages->byName('Home'), 500, "CMS home page doesn't exist, make sure to migrate the database first (php artisan migrate)");
        Session::put("pages_back_link", route('admin.home'));
        return view('admin.pages.form', $this->form($homepage->id));
        // return view('admin.pages.form', $this->form($homepage->id) + ['liveSiteUrl' => route('home')]);
    }

    protected function getRoutePrefix()
    {
        return null;
    }

}
