<?php

namespace Cp\Calendar;

use Cp\DomainObject\Week;
use Jsvrcek\ICS\Model\CalendarEvent;

class CalendarEventBuilder
{
    /**
     * @param Week $week
     *
     * @return array<CalendarEvent>
     */
    public function build(Week $week)
    {
        $events = [];
        foreach ($week->getTrainings() as $key => $training) {
            $event = new CalendarEvent();
            $event->setStart(new \DateTime('now +'.$key.' days'));
            $event->setEnd(new \DateTime('now +'.$key.' days +2 hours'));
            $event->setUid($training->getContent());
            $events[] = $event;
        }

        return $events;
    }
}