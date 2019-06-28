<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

use Illuminate\Support\Str;

class EventPresenter extends BasePresenter
{
    public function titleInBucket()
    {
        if ($this->entity->title) {
            return $this->entity->title;
        }

        return 'No title';
    }

    public function type()
    {
        if ($this->entity->event_type) {
            return \App\Models\Event::$eventTypes[$this->entity->event_type];
        }
    }

    public function headerType()
    {
        switch ($this->entity->layout_type) {
            case \App\Models\Event::LARGE_LAYOUT:
                return "feature";
                break;
            case \App\Models\Event::BASIC_LAYOUT:
                return null;
                break;
        }
    }

    public function ticketStatus()
    {
        if ($this->nextOcurrence == null) {
            return null;
        }

        if ($this->isSoldOut) {
            return 'sold-out';
        }

        if ($this->entity->is_private) {
            return 'rsvp';
        }

        if ($this->entity->is_registration_required) {
            return 'register';
        }

        if ($this->entity->is_free) {
            return 'free';
        }

        if ($this->entity->is_rsvp) {
            return 'rsvp';
        }

        if ($this->isTicketed) {
            return 'buy-ticket';
        }
    }

    public function formattedNextOcurrence()
    {
        if (!empty($this->entity->forced_date)) {
            return $this->entity->forced_date;
        } else {
            if ($next = $this->entity->nextOcurrenceExclusive) {

                return '<time datetime="'.$next->date->format("c").'" itemprop="startDate">'.$next->date->format('F j, Y | g:i').'</time>&ndash;<time datetime="'.$next->date_end->format("c").'" itemprop="endDate">'.$next->date_end->format('g:i').'</time>';
            } elseif ($last = $this->entity->lastOcurrence) {
                return '<time datetime="'.$last->date->format("c").'" itemprop="startDate">'.$last->date->format('F j, Y | g:i').'</time>&ndash;<time datetime="'.$last->date_end->format("c").'" itemprop="endDate">'.$last->date_end->format('g:i').'</time>';
            }
        }
    }

    public function nextOcurrenceDate()
    {
        if ($next = $this->entity->nextOcurrence) {
            return '<time datetime="'.$next->date->format("c").'" itemprop="startDate">'.$next->date->format('M j, Y').'</time>';
        }
    }

    public function nextOcurrenceTime()
    {
        if ($next = $this->entity->nextOcurrence) {

            return '<time datetime="'.$next->date->format("c").'" itemprop="startDate">'.$next->date->format('g:i').'</time>&ndash;<time datetime="'.$next->date_end->format("c").'" itemprop="endDate">'.$next->date_end->format('g:i').'</time>';
        }
    }

    public function navigation()
    {
        return array_filter([$this->locationLink(), $this->registrationRequired()]);
    }

    public function itemprops() {
        return [
            'isAccessibleForFree' => ($this->entity->ticketStatus === 'free') ? 'true' : 'false',
        ];
    }

    protected function locationLink() {
        if ($this->entity->location) {
            return [
                'label' => $this->entity->location,
                'iconBefore' => 'location',
                'itemprop' => 'location'
            ];
        }
    }

    protected function registrationRequired() {
        if ($this->entity->is_registration_required) {
            return [
                'label' => 'Registration required',
                'iconBefore' => 'pencil',
                'variation' => 'user'
            ];
        }
    }

    public function isTicketed()
    {
        if (!$this->entity->is_ticketed) {
            return false;
        }

        if ($this->entity->is_sales_button_hidden) {
            return false;
        }

        $ticketedEvent = $this->entity->apiModels('ticketedEvent', 'TicketedEvent')->first();

        return ( !isset($ticketedEvent) )
            || ( !$ticketedEvent->on_sale_at )
            || (
                 (
                   ($ticketedEvent->on_sale_at ?? false) && (
                       (new Carbon($ticketedEvent->on_sale_at))->lessThan(Carbon::now())
                   )
                 ) && (
                   ($ticketedEvent->off_sale_at ?? false) && (
                       (new Carbon($ticketedEvent->off_sale_at))->greaterThan(Carbon::now())
                   )
                 )
            );
    }

    /**
     * WEB-414: Do not use this in the API. Replicate this logic in the aggregator for touches.
     */
    public function isSoldOut()
    {
        $ticketedEvent = $this->entity->apiModels('ticketedEvent', 'TicketedEvent')->first();

        return $this->entity->is_sold_out || ($ticketedEvent->available ?? 1) < 1;
    }

    public function buyButtonText()
    {
        if ($this->entity->buy_button_text) {
            return $this->entity->buy_button_text;
        }

        return 'Buy tickets';
    }

    public function imageUrl() {
        $settings = aic_imageSettings([
            'image' => $this->entity->imageFront('hero'),
            'settings' => [
                'srcset' => array(1200),
                'sizes' => '1200px',
            ],
        ]);

        return Str::before($settings['srcset'], ' ');
    }
}
