<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasFiles;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Model;
use App\Models\Behaviors\HasMediasEloquent;
use Carbon\Carbon;
use DB;

class PressRelease extends Model
{
    use HasBlocks,  HasSlug, HasMedias, HasFiles, HasRevisions, HasMediasEloquent, Transformable;

    protected $fillable = [
        'short_description',
        'listing_description',
        'title',
        'published',
        'public',
        'publish_start_date',
        'publish_end_date',
        'migrated_node_id',
        'migrated_at',
    ];

    public $slugAttributes = [
        'title'
    ];

    public $checkboxes = ['published', 'active', 'public'];

    public $dates = ['publish_start_date', 'publish_end_date', 'migrated_at'];

    public $mediasParams = [
        'listing' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'mobile',
                    'ratio' => 1,
                ],
            ],
        ],
        'banner' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 200 / 24,
                ],
            ]
        ],
    ];

    public $filesParams = ['attachment']; // a list of file roles

    protected $presenter = 'App\Presenters\Admin\GenericPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\GenericPresenter';

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join([$this->id, $this->getSlug()], '-');
    }

    public function getUrlWithoutSlugAttribute()
    {
        return route('about.press.show', $this->id);
    }

    public function getSlugAttribute()
    {
        return route('about.press.show', $this);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('publish_start_date', 'desc');
    }

    public function scopeCurrent($query) {
        return $query->whereNull('publish_start_date')
            ->orWhere('publish_start_date', '>', Carbon::parse('2011-12-31'));
    }

    public function scopeArchive($query) {
        return $query->where('publish_start_date', '<=', Carbon::parse('2011-12-31'));
    }

    public function getUrlAttribute() {
        return url(route('about.press.show', $this->id_slug));
    }

    public function scopeByYear($query, $year) {
        return $query->where(DB::raw('EXTRACT( YEAR FROM publish_start_date )'), $year);
    }

    public function scopeByMonth($query, $year) {
        return $query->where(DB::raw('EXTRACT( MONTH FROM publish_start_date )'), $year);
    }

}
