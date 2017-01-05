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
     * @var TypeProvider
     */
    private $typeProvider;

    /**
     * PlanProvider constructor.
     *
     * @param PlanManager  $planManager
     * @param TypeProvider $typeProvider
     */
    public function __construct(PlanManager $planManager, TypeProvider $typeProvider)
    {
        $this->planManager = $planManager;
        $this->typeProvider = $typeProvider;
    }

    /**
     * @param Configuration $configuration
     *
     * @return Plan
     */
    public function getPlanByConfiguration(Configuration $configuration)
    {
        $typeName = $this->typeProvider->getTypeByKey($configuration->getType());

        return $this->planManager->findByType(
            $typeName,
            $configuration->getNumberOfWeek(),
            $configuration->getNumberOfSeance()
        );
    }
}
