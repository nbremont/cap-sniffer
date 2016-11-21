<?php

namespace Cp\Calendar\Builder;

use Cp\DomainObject\Week;
use Jsvrcek\ICS\Model\CalendarEvent;

/**
 * Class CalendarEventBuilder
 */
class CalendarEventBuilder
{
    /**
     * @param Week $week
     *
     * @return CalendarEvent[]
     */
    public function build(Week $week)
    {
        $events = [];
        foreach ($week->getTrainings() as $training) {
            $event = new CalendarEvent();
            $event->setUid(md5(uniqid()));
            $event->setSummary($training->getContent());
            $events[] = $event;
        }

        return $events;
    }
}
