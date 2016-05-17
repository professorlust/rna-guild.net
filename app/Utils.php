<?php namespace App;

use Calendar;
use Illuminate\Support\Collection;

class Utils
{
    /**
     * Create a Calendar with the given collection of events.
     *
     * @param  Collection  $events
     * @return array
     */
    public static function createCalendarFromEvents(Collection $events)
    {
        $calendarEvents = [];
        foreach ($events as $event) {
            $calendarEvents[] = Calendar::event(
                $event->title,
                $event->all_day,
                $event->starts,
                $event->ends,
                $event->id,
                [
                    'url' => $event->url,
                    'color' => '#f44336'
                ]
            );
        }

        return Calendar::addEvents($calendarEvents);
    }
}
