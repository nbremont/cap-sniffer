<?php

namespace Cp\Manager;

use Cp\Parser\TrainingParser;
use JMS\Serializer\SerializerBuilder;

/**
 * Class TrainingManager
 */
class TrainingManager
{
    /**
     * @var TrainingParser
     */
    private $trainingParser;

    /**
     * TrainingManager constructor.
     *
     * @param TrainingParser $trainingParser
     */
    public function __construct(TrainingParser $trainingParser)
    {
        $this->trainingParser = $trainingParser;
    }

    /**
     * @param string $week
     * @param string $nbTraining
     * @param string $type
     *
     * @return Plan
     */
    public function findByType($week, $nbTraining, $type)
    {
        $url = $this->urlTransformer->transform($week, $nbTraining, $type);
        $jsonString = $this->trainingParser->parseToJson($url);
        $serializer = SerializerBuilder::create()->build();

        return $serializer->deserialize($jsonString, 'Cp\DomainObject\Plan', 'json');
    }
}
