<?php

namespace App\Presenters\Admin;

use Carbon\Carbon;
use App\Presenters\BasePresenter;
use Illuminate\Support\Str;

class ExhibitionPresenter extends BasePresenter
{
    public function startDate()
    {
        if ($this->entity->start_date) {
            return $this->entity->start_date->format('M j, Y');
        }
    }

    // Passed to _m-article-header--* in exhibitionDetail.blade.php
    // Dead code? Template calls ->format on the string returned here
    // Used in App\Http\Controllers\Admin\ExhibitionController
    public function date()
    {
        $date = "";

        // Strangely, we cannot use isset() or empty() here
        $hasStart = $this->aic_start_at !== null;
        $hasEnd = $this->aic_end_at !== null;

        // These default gracefully to `now` if the attrs are empty
        $start = $this->entity->asDateTime($this->aic_start_at);
        $end = $this->entity->asDateTime($this->aic_end_at);

        if ($hasStart) {
            $date .= $start->format('m d Y');
        }

        if ($hasStart && $hasEnd) {
            $date .= '–';
        }

        if ($hasEnd){
            $date .= $end->format('m d Y');
        }

        return $date;
    }

    public function headerType()
    {
        switch ($this->entity->cms_exhibition_type) {
            case \App\Models\Exhibition::SPECIAL:
                return "super-hero";
                break;
            case \App\Models\Exhibition::LARGE:
                return "feature";
                break;
            case \App\Models\Exhibition::BASIC:
                return null;
                break;
        }
    }

    public function exhibitionType()
    {
        return $this->entity->isOngoing ? 'Ongoing' : 'Exhibition';
    }

    // Used in _m-listing----exhibition-history-row
    public function formattedDateCanonical()
    {
        return view('components.organisms._o-public-dates' , [
            'formattedDate' => $this->date_display_override,
            'dateStart' => $this->dateStart, // see getter
            'dateEnd' => $this->dateEnd, // see getter
            'date' => $this->date,
        ]);
    }

    // Used in member magazine
    public function formattedDate()
    {
        return view('components.organisms._o-public-dates' , [
            'formattedDate' => $this->date_display_override,
            'dateStart' => $this->startAt,
            'dateEnd' => $this->endAt,
            'date' => $this->date,
            'font' => '', // defaults to f-secondary
        ]);
    }

    public function startAt()
    {
        if ($this->entity->public_start_date != null) {
            return $this->entity->public_start_date;
        }
        elseif ($this->entity->aic_start_at != null) {
            return new Carbon($this->entity->aic_start_at);
        }
        else {
            return "";
        }
    }

    public function endAt()
    {
        if ($this->entity->public_end_date != null) {
            return $this->entity->public_end_date;
        }
        elseif ($this->entity->aic_end_at != null) {
            return new Carbon($this->entity->aic_end_at);
        }
        else {
            return "";
        }
    }

    public function navigation()
    {
        return array_filter([$this->galleryLink(), $this->relatedEventsLink(), $this->closingSoonLink()]);
    }

    public function navigationWithWaitTime()
    {
        return array_filter([$this->galleryLink(), $this->waitTime(), $this->relatedEventsLink(), $this->closingSoonLink()]);
    }

    public function itemprops() {
        return [
            'description' => $this->entity->short_description,
            'department'  => $this->entity->department_display,
        ];
    }

    protected function galleryLink() {
        $location = $this->entity->exhibition_location ?: $this->entity->gallery_title;
        if ($location) {
            return [
                'label' => $location,
                'iconBefore' => 'location'
            ];
        }
    }

    protected function waitTime() {
        $waitTime  = $this->entity->apiModels('waitTimes', 'WaitTime')->first();
        $waitTimeMember  = $this->entity->apiModels('waitTimes', 'WaitTime')->first();

        if ($waitTime || $waitTimeMember) {
            return [
                'label' => 'Current wait times<br/>'
                 . 'General Admission: ' . $waitTime->present()->display . '<br/>'
                 . 'Members: ' . $waitTimeMember->present()->display,
                'iconBefore' => 'clock'
            ];
        }
        return [];
    }

    protected function relatedEventsLink() {
        $count = $this->entity->eventsCount();

        if ($count > 0) {
            return [
                'label' =>  $count . ' related ' . Str::plural('event', $count),
                'href' => '#related_events',
                'iconBefore' => 'calendar'
            ];
        }
    }

    protected function closingSoonLink() {
        if ($this->entity->isOngoing) {
           return [
                'label' => 'Ongoing',
                'variation' => 'ongoing'
            ];
        } else if($this->entity->isClosed) {
             return [
                'label' => 'Closed',
                'variation' => 'closing-soon'
            ];
        } else if($this->entity->isNowOpen) {
             return [
                'label' => 'Now Open',
                'variation' => 'ongoing'
            ];
        } else if($this->entity->isClosingSoon) {
             return [
                'label' => 'Closing Soon',
                'variation' => 'closing-soon'
            ];
        } else if($this->entity->exclusive) {
            return [
                'label' => 'Member Exclusive',
                'variation' => 'ongoing'
            ];
        }
    }

    protected function augmented() {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }

    public function addInjectAttributes($variation = null) {
        if (date('H') >= 10 && date('H') < 20) {
            return 'class="o-injected-container" data-behavior="injectContent" data-injectContent-url="' . route('exhibitions.waitTime', ['id' => $this->entity->id, 'slug' => $this->entity->getSlug(), 'variation' => $variation]) . '"';
        }
        return null;
    }
}
