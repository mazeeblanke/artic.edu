@php
    use App\Repositories\EventRepository;
    use App\Models\Event;
    use Carbon\Carbon;

    $dateStart = $block->input('date_start') ? Carbon::parse($block->input('date_start')) : Carbon::now();
    $dateEnd = $block->input('date_end') ? Carbon::parse($block->input('date_end')) : Carbon::tomorrow()->addMonths(6);

    $events = (new EventRepository(new Event))->getEventsFiltered(
        $dateStart,
        $dateEnd,
        null,
        $block->input('type'),
        $block->input('audience'),
        null,
        4,
        null,
        false,
        function (&$query) {
            $query->getQuery()->orders = null;
            $query->orderBy('event_metas.date', 'ASC');
        }
    );

    $items = $events->map(function($event) {
        return [
            'title' => $event->title_display ?? $event->title,
            'dateDisplay' => $event->present()->formattedBlockDate(),
            'href' => route('events.show', $event),
        ];
    });
@endphp

@if ($items && $items->count() > 0)
    @component('components.molecules._m-listing----publication-happenings')
        @slot('variation', 'm-listing--publication-happenings--events m-listing--magazine')
        @slot('title', $block->input('title') ?? null)
        @slot('btnText', 'See all events')
        @slot('btnHref', route('events'))
        @slot('items', $items)
    @endcomponent
@endif
