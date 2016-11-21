<?php

namespace Cp\Calendar\Builder;

use Cp\DomainObject\Plan;
use Jsvrcek\ICS\CalendarExport;
use Jsvrcek\ICS\Model\Calendar;

/**
 * Class CalendarBuilder
 */
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
     */
    public function build(Plan $plan)
    {
        $calendar = new Calendar();
        $calendar->setProdId($plan->getName());
        $initialDate = new \DateTime();
        $initialDate->modify('- '.$this->getRecoveryDay($plan->getConfiguration()->getNumberOfSeance())[0].' day');

        foreach ($plan->getWeeks() as $week) {
            $events = $this->calendarEventBuilder->build($week);
            foreach ($events as $key => $event) {
                $event->setStart(clone $initialDate->modify('+'.$this->getRecoveryDay(count($events))[$key].' day'));
                $calendar->addEvent($event);
            }
        }

        $this->calendarExport->addCalendar($calendar);
    }

    /**
     * @param int $numSeance
     *
     * @return array
     */
    public function getRecoveryDay($numSeance)
    {
        switch ($numSeance) {
            case 3:
                return [3, 3, 3];
            case 4:
                return [2, 2, 2, 2];
            case 5:
                return [1, 2, 1, 2, 1];
            case 6:
                return [1, 1, 1, 1, 1, 1];
            case 7:
                return [1, 1, 1, 1, 1, 1, 1];
        }
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
}
