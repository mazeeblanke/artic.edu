<?php

namespace App\Models;

use Carbon\Carbon;

class Hour extends AbstractModel
{
    use Transformable;

    protected $presenter = 'App\Presenters\HoursPresenter';
    protected $presenterAdmin = 'App\Presenters\HoursPresenter';

    protected $fillable = [
        'valid_from',
        'valid_through',
        'type',
        'title',
        'url',
        'monday_is_closed',
        'monday_member_open',
        'monday_member_close',
        'monday_public_open',
        'monday_public_close',
        'tuesday_is_closed',
        'tuesday_member_open',
        'tuesday_member_close',
        'tuesday_public_open',
        'tuesday_public_close',
        'wednesday_is_closed',
        'wednesday_member_open',
        'wednesday_member_close',
        'wednesday_public_open',
        'wednesday_public_close',
        'thursday_is_closed',
        'thursday_member_open',
        'thursday_member_close',
        'thursday_public_open',
        'thursday_public_close',
        'friday_is_closed',
        'friday_member_open',
        'friday_member_close',
        'friday_public_open',
        'friday_public_close',
        'saturday_is_closed',
        'saturday_member_open',
        'saturday_member_close',
        'saturday_public_open',
        'saturday_public_close',
        'sunday_is_closed',
        'sunday_member_open',
        'sunday_member_close',
        'sunday_public_open',
        'sunday_public_close',
        'additional_text',
        'summary',
        'published',
    ];

    public static $types = [
        0 => 'Museum',
        1 => 'Shop',
        2 => 'Library',
    ];

    protected $dates = [
        'valid_from',
        'valid_through',
    ];

    /**
     * Those fields get auto set to null if not submitted
     */
    public $nullable = [];

    /**
     * Those fields get auto set to false if not submitted
     */
    public $checkboxes = [
        'published',
        'monday_is_closed',
        'tuesday_is_closed',
        'wednesday_is_closed',
        'thursday_is_closed',
        'friday_is_closed',
        'saturday_is_closed',
        'sunday_is_closed',
    ];

    public function scopeToday($query, $type = 0)
    {
        $today = Carbon::today();

        $queryModified = clone $query;
        $queryModified
            ->published()
            ->where('type', $type)
            ->whereDate('valid_from', '<=', $today)
            ->whereDate('valid_through', '>=', $today)
            ->orWhere
            ->whereNull('valid_through');

        return $queryModified->exists() ? $queryModified : $this->scopeDefault($query, $type);
    }

    public function scopeDefault($query, $type = 0)
    {
        return $query
            ->published()
            ->where('type', $type)
            ->whereNull('valid_from')
            ->whereNull('valid_through');
    }

    public function buildingClosures()
    {
        return $this->hasMany(\App\Models\BuildingClosure::class);
    }

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'valid_from',
                'doc' => 'Valid From',
                'type' => 'datetime',
                'value' => function () {
                    return $this->valid_from;
                },
            ],
            [
                'name' => 'valid_through',
                'doc' => 'Valid Through',
                'type' => 'datetime',
                'value' => function () {
                    return $this->valid_through;
                },
            ],
            [
                'name' => 'type',
                'doc' => 'Type',
                'type' => 'number',
                'value' => function () {
                    return $this->type;
                },
            ],
            [
                'name' => 'title',
                'doc' => 'Title',
                'type' => 'string',
                'value' => function () {
                    return $this->title;
                },
            ],

            [
                'name' => 'monday_is_closed',
                'doc' => 'Is closed Monday',
                'type' => 'boolean',
                'value' => function () {
                    return (bool) $this->monday_is_closed;
                },
            ],
            [
                'name' => 'monday_member_open',
                'doc' => 'Monday - member open time',
                'type' => 'string',
                'value' => function () {
                    return $this->monday_member_open;
                },
            ],
            [
                'name' => 'monday_member_close',
                'doc' => 'Monday - member close time',
                'type' => 'string',
                'value' => function () {
                    return $this->monday_member_close;
                },
            ],
            [
                'name' => 'monday_public_open',
                'doc' => 'Monday - public open time',
                'type' => 'string',
                'value' => function () {
                    return $this->monday_public_open;
                },
            ],
            [
                'name' => 'monday_public_close',
                'doc' => 'Monday - public close time',
                'type' => 'string',
                'value' => function () {
                    return $this->monday_public_close;
                },
            ],

            [
                'name' => 'tuesday_is_closed',
                'doc' => 'Is closed Tuesday',
                'type' => 'boolean',
                'value' => function () {
                    return (bool) $this->tuesday_is_closed;
                },
            ],
            [
                'name' => 'tuesday_member_open',
                'doc' => 'Tuesday - member open time',
                'type' => 'string',
                'value' => function () {
                    return $this->tuesday_member_open;
                },
            ],
            [
                'name' => 'tuesday_member_close',
                'doc' => 'Tuesday - member close time',
                'type' => 'string',
                'value' => function () {
                    return $this->tuesday_member_close;
                },
            ],
            [
                'name' => 'tuesday_public_open',
                'doc' => 'Tuesday - public open time',
                'type' => 'string',
                'value' => function () {
                    return $this->tuesday_public_open;
                },
            ],
            [
                'name' => 'tuesday_public_close',
                'doc' => 'Tuesday - public close time',
                'type' => 'string',
                'value' => function () {
                    return $this->tuesday_public_close;
                },
            ],

            [
                'name' => 'wednesday_is_closed',
                'doc' => 'Is closed Wednesday',
                'type' => 'boolean',
                'value' => function () {
                    return (bool) $this->wednesday_is_closed;
                },
            ],
            [
                'name' => 'wednesday_member_open',
                'doc' => 'Wednesday - member open time',
                'type' => 'string',
                'value' => function () {
                    return $this->wednesday_member_open;
                },
            ],
            [
                'name' => 'wednesday_member_close',
                'doc' => 'Wednesday - member close time',
                'type' => 'string',
                'value' => function () {
                    return $this->wednesday_member_close;
                },
            ],
            [
                'name' => 'wednesday_public_open',
                'doc' => 'Wednesday - public open time',
                'type' => 'string',
                'value' => function () {
                    return $this->wednesday_public_open;
                },
            ],
            [
                'name' => 'wednesday_public_close',
                'doc' => 'Wednesday - public close time',
                'type' => 'string',
                'value' => function () {
                    return $this->wednesday_public_close;
                },
            ],

            [
                'name' => 'thursday_is_closed',
                'doc' => 'Is closed Thursday',
                'type' => 'boolean',
                'value' => function () {
                    return (bool) $this->thursday_is_closed;
                },
            ],
            [
                'name' => 'thursday_member_open',
                'doc' => 'Thursday - member open time',
                'type' => 'string',
                'value' => function () {
                    return $this->thursday_member_open;
                },
            ],
            [
                'name' => 'thursday_member_close',
                'doc' => 'Thursday - member close time',
                'type' => 'string',
                'value' => function () {
                    return $this->thursday_member_close;
                },
            ],
            [
                'name' => 'thursday_public_open',
                'doc' => 'Thursday - public open time',
                'type' => 'string',
                'value' => function () {
                    return $this->thursday_public_open;
                },
            ],
            [
                'name' => 'thursday_public_close',
                'doc' => 'Thursday - public close time',
                'type' => 'string',
                'value' => function () {
                    return $this->thursday_public_close;
                },
            ],

            [
                'name' => 'friday_is_closed',
                'doc' => 'Is closed Friday',
                'type' => 'boolean',
                'value' => function () {
                    return (bool) $this->friday_is_closed;
                },
            ],
            [
                'name' => 'friday_member_open',
                'doc' => 'Friday - member open time',
                'type' => 'string',
                'value' => function () {
                    return $this->friday_member_open;
                },
            ],
            [
                'name' => 'friday_member_close',
                'doc' => 'Friday - member close time',
                'type' => 'string',
                'value' => function () {
                    return $this->friday_member_close;
                },
            ],
            [
                'name' => 'friday_public_open',
                'doc' => 'Friday - public open time',
                'type' => 'string',
                'value' => function () {
                    return $this->friday_public_open;
                },
            ],
            [
                'name' => 'friday_public_close',
                'doc' => 'Friday - public close time',
                'type' => 'string',
                'value' => function () {
                    return $this->friday_public_close;
                },
            ],

            [
                'name' => 'saturday_is_closed',
                'doc' => 'Is closed Saturday',
                'type' => 'boolean',
                'value' => function () {
                    return (bool) $this->saturday_is_closed;
                },
            ],
            [
                'name' => 'saturday_member_open',
                'doc' => 'Saturday - member open time',
                'type' => 'string',
                'value' => function () {
                    return $this->saturday_member_open;
                },
            ],
            [
                'name' => 'saturday_member_close',
                'doc' => 'Saturday - member close time',
                'type' => 'string',
                'value' => function () {
                    return $this->saturday_member_close;
                },
            ],
            [
                'name' => 'saturday_public_open',
                'doc' => 'Saturday - public open time',
                'type' => 'string',
                'value' => function () {
                    return $this->saturday_public_open;
                },
            ],
            [
                'name' => 'saturday_public_close',
                'doc' => 'Saturday - public close time',
                'type' => 'string',
                'value' => function () {
                    return $this->saturday_public_close;
                },
            ],

            [
                'name' => 'sunday_is_closed',
                'doc' => 'Is closed Sunday',
                'type' => 'boolean',
                'value' => function () {
                    return (bool) $this->sunday_is_closed;
                },
            ],
            [
                'name' => 'sunday_member_open',
                'doc' => 'Sunday - member open time',
                'type' => 'string',
                'value' => function () {
                    return $this->sunday_member_open;
                },
            ],
            [
                'name' => 'sunday_member_close',
                'doc' => 'Sunday - member close time',
                'type' => 'string',
                'value' => function () {
                    return $this->sunday_member_close;
                },
            ],
            [
                'name' => 'sunday_public_open',
                'doc' => 'Sunday - public open time',
                'type' => 'string',
                'value' => function () {
                    return $this->sunday_public_open;
                },
            ],
            [
                'name' => 'sunday_public_close',
                'doc' => 'Sunday - public close time',
                'type' => 'string',
                'value' => function () {
                    return $this->sunday_public_close;
                },
            ],

            [
                'name' => 'additional_text',
                'doc' => 'Additional text',
                'type' => 'string',
                'value' => function () {
                    return $this->additional_text;
                },
            ],
            [
                'name' => 'summary',
                'doc' => 'Summary',
                'type' => 'string',
                'value' => function () {
                    return $this->summary;
                },
            ],
            [
                'name' => 'url',
                'doc' => 'URL',
                'type' => 'string',
                'value' => function () {
                    return $this->url;
                },
            ],
            [
                'name' => 'published',
                'doc' => 'Published',
                'type' => 'boolean',
                'value' => function () {
                    return $this->published;
                },
            ],
        ];
    }

    public static function getOpening()
    {
        $hour = Hour::today()->first();

        return $hour->title ?? 'Open daily 10:30&ndash;5:00';
    }

    public static function getOpeningUnlessClosure()
    {
        $closure = app('closureservice')->getClosure();

        return $closure ? null : self::getOpening();
    }

    public static function getOpeningUrl()
    {
        $hour = Hour::today()->first();

        return $hour->url ?? 'visit';
    }
}
