<?php

namespace Cp\Manager;

use Cp\DomainObject\Plan;
use Cp\Exception\ConfigurationNotFoundException;
use Cp\Parser\PlanParser;
use Cp\Transformer\UrlTransformer;
use Doctrine\Common\Cache\MemcachedCache;
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
     * @var MemcachedCache
     */
    private $memcache;

    /**
     * TrainingManager constructor.
     *
     * @param PlanParser     $planParser
     * @param UrlTransformer $urlTransformer
     * @param Serializer     $serializer
     * @param MemcachedCache $memcached
     */
    public function __construct(
        PlanParser $planParser,
        UrlTransformer $urlTransformer,
        Serializer $serializer,
        MemcachedCache $memcached
    ) {
        $this->planParser = $planParser;
        $this->urlTransformer = $urlTransformer;
        $this->serializer = $serializer;
        $this->memcache = $memcached;
    }

    /**
     * @param int    $week
     * @param int    $seance
     * @param string $type
     *
     * @return Plan
     * @throws ConfigurationNotFoundException
     */
    public function findByType($week, $seance, $type)
    {
        $plan = $this->memcache->fetch($week.$seance.$type);
        if (false === $plan) {
            try {
                $jsonString = $this->planParser->parseToJson(
                    $this->urlTransformer->transformPlan($week, $seance, $type)
                );
            } catch (\Exception $e) {
                throw new ConfigurationNotFoundException(
                    sprintf(
                        'Configuration with week: %s, seance: %s and type:%s is not available',
                        $week,
                        $seance,
                        $type
                    )
                );
            }
            $plan = $this->serializer->deserialize($jsonString, Plan::class, 'json');
            $this->memcache->save($week.$seance.$type, $plan, 3600);
        }

        return $plan;
    }
}
