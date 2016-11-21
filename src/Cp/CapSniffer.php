<?php

namespace Cp;

use Cocur\Slugify\Slugify;
use Cp\Calendar\Builder\CalendarBuilder;
use Cp\DomainObject\Configuration;
use Cp\Provider\PlanProvider;
use Cp\Provider\TypeProvider;

/**
 * Class CapSniffer
 */
class CapSniffer
{
    /**
     * @var TypeProvider
     */
    private $typeProvider;

    /**
     * @var PlanProvider
     */
    private $planProvider;

    /**
     * @var Slugify
     */
    private $slug;

    /**
     * @var CalendarBuilder
     */
    private $calendarBuilder;

    /**
     * CapSniffer constructor.
     *
     * @param TypeProvider    $typeProvider
     * @param PlanProvider    $planProvider
     * @param CalendarBuilder $calendarBuilder
     * @param Slugify         $slug
     */
    public function __construct(
        TypeProvider $typeProvider,
        PlanProvider $planProvider,
        CalendarBuilder $calendarBuilder,
        Slugify $slug
    ) {
        $this->typeProvider = $typeProvider;
        $this->planProvider = $planProvider;
        $this->calendarBuilder = $calendarBuilder;
        $this->slug = $slug;
    }

    /**
     * @param string $typeName
     * @param string $week
     * @param string $seance
     *
     * @return string
     */
    public function generateCalendar($typeName, $week, $seance)
    {
        return $this->calendarBuilder->exportCalendar($this->getPlan($typeName, $week, $seance));
    }

    /**
     * @param string $typeName
     * @param string $week
     * @param string $seance
     */
    public function writeCalendar($typeName, $week, $seance)
    {
        $plan = $this->getPlan($typeName, $week, $seance);
        file_put_contents(
            __DIR__.'/../../'.$this->slug->slugify($plan->getName()).'.ics',
            $this->generateCalendar($typeName, $week, $seance)
        );
    }

    /**
     * @param string $typeName
     * @param string $week
     * @param string $seance
     *
     * @return Plan
     */
    public function getPlan($typeName, $week, $seance)
    {
        $configuration = $this->createConfiguration($typeName, $week, $seance);
        $plan = $this->planProvider->getPlanByConfiguration($configuration);
        $plan->setConfiguration($configuration);

        return $plan;
    }

    /**
     * @param $typeName
     * @param $week
     * @param $seance
     *
     * @return Configuration
     */
    private function createConfiguration($typeName, $week, $seance)
    {
        $type = $this->typeProvider->getType($typeName);

        $configuration = new Configuration();
        $configuration->setType($type);
        $configuration->setNumberOfWeek($week);
        $configuration->setNumberOfSeance($seance);

        return $configuration;
    }
}
