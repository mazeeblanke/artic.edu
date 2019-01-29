<?php

namespace App\Models;

use Carbon\Carbon;

class Hour extends AbstractModel
{
    use Transformable;

    protected $presenter = 'App\Presenters\HoursPresenter';
    protected $presenterAdmin = 'App\Presenters\HoursPresenter';

    static $days = array(
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    );

    protected $fillable = [
        'day_of_week',
        'opening_time',
        'closing_time',
        'type',
        'closed',
    ];

    public static $types = [
        0 => 'Museum',
        1 => 'Shop',
        2 => 'Library',
    ];

    public $dates = ['opening_time', 'closing_time'];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = ['closed'];

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'opening_time',
                "doc" => "Opening Time",
                "type" => "datetime",
                "value" => function () {return $this->opening_time;},
            ],
            [
                "name" => 'closing_time',
                "doc" => "Closing Time",
                "type" => "datetime",
                "value" => function () {return $this->closing_time;},
            ],
            [
                "name" => 'type',
                "doc" => "Type",
                "type" => "number",
                "value" => function () {return $this->type;},
            ],
            [
                "name" => 'day_of_week',
                "doc" => "Day of Week",
                "type" => "number",
                "value" => function () {return $this->day_of_week;},
            ],
            [
                "name" => 'closed',
                "doc" => "Closed",
                "type" => "boolean",
                "value" => function () {return $this->closed;},
            ],
        ];
    }

    public static function getOpening()
    {
        return 'Open daily 10:30&ndash;5:00, Thursdays until 8:00';
    }

    public static function getOpeningUnlessClosure()
    {
        $closure = Closure::today()->first();

        return $closure ? null : self::getOpening();
    }

    /**
     * TODO: Dead code. Delete?
     */
    public static function getOpeningWithClosure()
    {
        $closure = Closure::today()->first();
        if ($closure) {
            return $closure->closure_copy;
        }

        return self::getOpening();
    }

    /**
     * TODO: Dead code. Delete?
     */
    public static function getOpeningToday($type = 0)
    {
        $day = date('N');
        $today = Carbon::today();

        $closure = Closure::published()->where('date_start', '>=', $today)->where('date_end', '<=', $today)->first();
        if ($closure) {
            return $closure->closure_copy;
        } else {
            $hours = Hour::where('type', $type)->where('day_of_week', $day)->first();
            if ($hours && $hours->opening_time && $hours->closing_time) {
                return "Open today " . $hours->opening_time->format('g:i') . '&ndash;' . $hours->closing_time->format('g:i');
            }
        }

        return "";
    }
}
