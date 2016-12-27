<?php

namespace Cp;

use Cocur\Slugify\Slugify;
use Cp\Calendar\Builder\CalendarBuilder;
use Cp\DomainObject\Configuration;
use Cp\Manager\ConfigurationManager;
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
     * @var ConfigurationManager
     */
    private $configurationManager;

    /**
     * CapSniffer constructor.
     *
     * @param TypeProvider         $typeProvider
     * @param PlanProvider         $planProvider
     * @param CalendarBuilder      $calendarBuilder
     * @param Slugify              $slug
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(
        TypeProvider $typeProvider,
        PlanProvider $planProvider,
        CalendarBuilder $calendarBuilder,
        Slugify $slug,
        ConfigurationManager $configurationManager
    ) {
        $this->typeProvider = $typeProvider;
        $this->planProvider = $planProvider;
        $this->calendarBuilder = $calendarBuilder;
        $this->slug = $slug;
        $this->configurationManager = $configurationManager;
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
        $configuration = $this->configurationManager->createConfiguration($typeName, $week, $seance);
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

    public function testConfigurationParse()
    {
        $result = $this->configurationManager->findConfigurationsByType('plan-entrainement-10km');
        var_dump($result); die;
    }
}
