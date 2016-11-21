<?php

namespace Cp\Provider;

use Cp\DomainObject\Configuration;
use Cp\DomainObject\Plan;
use Cp\Manager\PlanManager;

/**
 * Class PlanProvider
 */
class PlanProvider
{
    /**
     * @var PlanManager
     */
    private $planManager;

    /**
     * PlanProvider constructor.
     *
     * @param PlanManager $planManager
     */
    public function __construct(PlanManager $planManager)
    {
        $this->planManager = $planManager;
    }

    /**
     * @param Configuration $configuration
     *
     * @return Plan
     */
    public function getPlanByConfiguration(Configuration $configuration)
    {
        return $this->planManager->findByType(
            $configuration->getNumberOfWeek(),
            $configuration->getNumberOfSeance(),
            $configuration->getType()
        );
    }
}
