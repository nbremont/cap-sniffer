<?php

namespace Cp\DomainObject;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Plan
 */
class Plan
{
    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    private $type;

    /**
     * @var array
     *
     * @JMS\Type("array<Cp\DomainObject\Week>")
     */
    private $weeks;

    /**
     * @var Configuration
     */
    private $configuration;


    /**
     * PlanTraining constructor.
     */
    public function __construct()
    {
        $this->weeks = [];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getWeeks()
    {
        return $this->weeks;
    }

    /**
     * @param Week $week
     */
    public function addWeek(Week $week)
    {
        $this->weeks[] = $week;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $stream = $this->getType().':'.$this->getName()."\n";
        foreach ($this->getWeeks() as $week) {
            $stream .= (string) $week;
        }

        return $stream;
    }
}
