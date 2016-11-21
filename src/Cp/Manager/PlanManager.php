<?php

namespace Cp\Manager;

use Cp\DomainObject\Plan;
use Cp\Exception\ConfigurationException;
use Cp\Parser\PlanParser;
use Cp\Transformer\UrlTransformer;
use JMS\Serializer\Serializer;

/**
 * Class PlanManager
 */
class PlanManager
{
    /**
     * @var PlanParser
     */
    private $planParser;

    /**
     * @var UrlTransformer
     */
    private $urlTransformer;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * TrainingManager constructor.
     *
     * @param PlanParser     $planParser
     * @param UrlTransformer $urlTransformer
     * @param Serializer     $serializer
     */
    public function __construct(
        PlanParser $planParser,
        UrlTransformer $urlTransformer,
        Serializer $serializer
    ) {
        $this->planParser = $planParser;
        $this->urlTransformer = $urlTransformer;
        $this->serializer = $serializer;
    }

    /**
     * @param int    $week
     * @param int    $seance
     * @param string $type
     *
     * @return Plan
     * @throws ConfigurationException
     */
    public function findByType($week, $seance, $type)
    {
        try {
            $jsonString = $this->planParser->parseToJson(
                $this->urlTransformer->transformPlan($week, $seance, $type)
            );
        } catch (\Exception $e) {
            throw new ConfigurationException(
                sprintf('Configuration with week: %s, seance: %s and type:%s is not available', $week, $seance, $type)
            );
        }

        return $this->serializer->deserialize($jsonString, Plan::class, 'json');
    }
}
