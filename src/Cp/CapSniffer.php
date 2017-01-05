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
     * @param string $type
     * @param string $week
     * @param string $seance
     *
     * @return string
     */
    public function generateCalendar($type, $week, $seance)
    {
        return $this->calendarBuilder->exportCalendar($this->getPlan($type, $week, $seance));
    }

    /**
     * @param string $type
     * @param string $week
     * @param string $seance
     */
    public function writeCalendar($type, $week, $seance)
    {
        file_put_contents(
            __DIR__.'/../../'.$this->getFileName($type, $week, $seance),
            $this->generateCalendar($type, $week, $seance)
        );
    }

    /**
     * @param string $type
     * @param string $week
     * @param string $seance
     *
     * @return Plan
     */
    public function getPlan($type, $week, $seance)
    {
        $configuration = $this->configProvider->getConfiguration($type, $week, $seance);
        $plan = $this->planProvider->getPlanByConfiguration($configuration);
        $plan->setConfiguration($configuration);

        return $plan;
    }

    /**
     * @param string $type
     * @param string $week
     * @param string $seance
     *
     * @return string
     */
    public function getFileName($type, $week, $seance)
    {
        return $this->slug->slugify($this->getPlan($type, $week, $seance)->getName()).'.ics';
    }
}
