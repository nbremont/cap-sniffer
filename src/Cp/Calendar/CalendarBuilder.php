<?php

namespace Cp\Calendar;

use Cp\DomainObject\Plan;
use Jsvrcek\ICS\CalendarExport;
use Jsvrcek\ICS\Model\Calendar;
use Jsvrcek\ICS\Model\CalendarEvent;

class CalendarBuilder
{
    /**
     * @var CalendarExport
     */
    private $calendarExport;

    /**
     * @var CalendarEventBuilder
     */
    private $calendarEventBuilder;

    /**
     * @var array
     */
    private $events;

    /**
     * CalendarBuilder constructor.
     *
     * @param CalendarExport       $calendarExport
     * @param CalendarEventBuilder $calendarEventBuilder
     */
    public function __construct(CalendarExport $calendarExport, CalendarEventBuilder $calendarEventBuilder)
    {
        $this->calendarExport = $calendarExport;
        $this->calendarEventBuilder = $calendarEventBuilder;
    }

    /**
     * @param Plan $plan
     *
     * @return string
     */
    public function build(Plan $plan)
    {
        $calendar = new Calendar();
        $calendar->setProdId($plan->getName());
        $calendar->setTimezone(new \DateTimeZone('Europe/Paris'));
        $initialDate = new \DateTime('-2 day');

        foreach ($plan->getWeeks() as $week) {
            $events = $this->calendarEventBuilder->build($week);
            foreach ($events as $event) {
                $event->setStart(clone $initialDate->modify('+2 day'));
                $calendar->addEvent($event);
            }
        }

        $this->calendarExport->addCalendar($calendar);
    }

    /**
     * @param Plan $plan
     *
     * @return array
     */
    public function exportCalendar(Plan $plan)
    {
        $this->build($plan);

        return $this->calendarExport->getStream();
    }

    /**
     * @param CalendarEvent $event
     */
    public function addEvent(CalendarEvent $event)
    {
        $this->events[] = $event;
    }
}
