<?php

namespace Cp;

use Cocur\Slugify\Slugify;
use Cp\Calendar\Builder\CalendarBuilder;
use Cp\Provider\ConfigurationProvider;
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
     * @var ConfigurationProvider
     */
    private $configProvider;

    /**
     * CapSniffer constructor.
     *
     * @param CalendarBuilder       $calendarBuilder
     * @param TypeProvider          $typeProvider
     * @param PlanProvider          $planProvider
     * @param ConfigurationProvider $configProvider
     * @param Slugify               $slug
     *
     * @internal param ConfigurationProvider $configurationManager
     */
    public function __construct(
        CalendarBuilder $calendarBuilder,
        TypeProvider $typeProvider,
        PlanProvider $planProvider,
        ConfigurationProvider $configProvider,
        Slugify $slug
    ) {
        $this->calendarBuilder = $calendarBuilder;
        $this->typeProvider = $typeProvider;
        $this->planProvider = $planProvider;
        $this->configProvider = $configProvider;
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
        file_put_contents(
            __DIR__.'/../../'.$this->getFileName($typeName, $week, $seance),
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
        $configuration = $this->configProvider->getConfiguration($typeName, $week, $seance);
        $plan = $this->planProvider->getPlanByConfiguration($configuration);
        $plan->setConfiguration($configuration);

        return $plan;
    }

    /**
     * @param string $typeName
     * @param string $week
     * @param string $seance
     *
     * @return string
     */
    public function getFileName($typeName, $week, $seance)
    {
        return $this->slug->slugify($this->getPlan($typeName, $week, $seance)->getName()).'.ics';
    }
}
