<?php

namespace App\Models;

use A17\CmsToolkit\Models\Model;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;

class Exhibition extends Model
{
    use HasRevisions, HasSlug, HasMedias;

    protected $presenterAdmin = 'App\Presenters\Admin\ExhibitionPresenter';

    protected $fillable = [
        'published',
        'landing',
        'content',
        'title',
        'header_copy',
        'start_date',
        'end_date',
        'short_copy',
        'datahub_id'
    ];

    public $slugAttributes = [
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];

    public $dates = ['start_date', 'end_date'];

    public $mediasParams = [
        'hero' => [
            'default' => '16/9',
            'square' => '1',
        ]
    ];

    public function siteTags()
    {
        return $this->morphToMany(\App\Models\SiteTag::class, 'site_taggable', 'site_tagged');
    }

    public function scopeLanding($query)
    {
        return $query->whereLanding(true);
    }

    public function events()
    {
        return $this->belongsToMany(\App\Models\Event::class, 'event_exhibition', 'event_id', 'exhibition_id')->withPivot('position')->orderBy('position');
    }
}
