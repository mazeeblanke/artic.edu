<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use A17\CmsToolkit\Models\Behaviors\HasPresenter;
use Illuminate\Support\Carbon;

class Exhibition extends BaseApiModel
{
    use HasPresenter;

    protected $endpoints = [
        'collection' => '/api/v1/exhibitions',
        'resource'   => '/api/v1/exhibitions/{id}',
        'search'     => '/api/v1/exhibitions/search'
    ];

    protected $appends = ['date'];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\Exhibition';

    protected $presenter       = 'App\Presenters\Admin\ExhibitionPresenter';
    protected $presenterAdmin  = 'App\Presenters\Admin\ExhibitionPresenter';

    // Generates the id-slug type of URL
    public function getRouteKeyName() {
        return 'id_slug';
    }

    public function getIdSlugAttribute() {
        return join(array_filter([$this->id, $this->getSlug()]), '-');
    }

    public function getDateStartAttribute() {
        return new Carbon($this->start_at);
    }

    public function getDateEndAttribute() {
        return new Carbon($this->end_at);
    }


    // EXAMPLE SCOPE:
    // Search for all exhibitions for the next 2 weeks, not closed
    public function scopeCurrent($query) {
        $params = [
          'bool' => [
            'must' => [
              0 => [
                'range' => [
                  'end_at' => [
                    'gte' => 'now',
                  ],
                ],
              ],
              1 => [
                'range' => [
                  'start_at' => [
                    'lte' => 'now',
                  ],
                ],
              ],
            ],
            'must_not' => [
              'term' => [
                'status' => 'Closed',
              ],
            ],
          ],
        ];

        return $query->rawSearch($params);
    }

    public function scopeUpcoming($query) {
        $params = [
          'bool' => [
            'must' => [
              0 => [
                'range' => [
                  'start_at' => [
                    'gte' => 'now',
                  ],
                ],
              ],
            ],
          ],
        ];

        return $query->rawSearch($params);
    }

    public function scopeHistory($query, $year=null) {
        if ($year == null) {
            $params = [
              'bool' => [
                'must' => [
                  0 => [
                    'range' => [
                      'end_at' => [
                        'lte' => 'now',
                      ],
                    ],
                  ],
                ],
              ],
            ];
        } else {
            $start = $year.'-01-01';
            $end = $year.'-12-31';
            $params = [
              'bool' => [
                'must' => [
                  0 => [
                    'range' => [
                      'end_at' => [
                        'lte' => $end
                      ],
                    ],
                  ],
                  1 => [
                    'range' => [
                      'start_at' => [
                        'gte' => $start
                      ],
                    ],
                  ],
                  2 => [
                      'term' => [
                        'status' => 'Closed',
                      ],
                  ],
                ],
              ],
            ];
        }

        return $query->orderBy('start_at', 'asc')->rawSearch($params);
    }


    // Solve this using casts. Because it returns an object it can't be used on the CMS
    // A value option could be added when showing
    // public function getStartAtAttribute($value) {
    //     return $this->asDateTime($value)->format("Y-m-d h:m:s T");
    // }

    // public function getEndAtAttribute($value) {
    //     return $this->asDateTime($value)->format("Y-m-d h:m:s T");
    // }

    public function artworks()
    {
        return $this->hasMany(\App\Models\Api\Artwork::class, 'artwork_ids');
    }

    public function artists()
    {
        return $this->hasMany(\App\Models\Api\Artist::class, 'artist_ids');
    }
}
