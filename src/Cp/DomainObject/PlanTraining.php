<?php

namespace Cp\DomainObject;

use JMS\Serializer\Annotation as JMS;

class PlanTraining
{
    /**
     * @var string
     *
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @var array
     *
     * @JMS\Expose
     * @JMS\Type("array<Cp\DomainObject\WeekTraining>")
     */
    private $weekTrainings;


    /**
     * PlanTraining constructor.
     */
    public function __construct()
    {
        $this->weekTrainings = [];
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
     * @return array
     */
    public function getWeekTrainings()
    {
        return $this->weekTrainings;
    }

    /**
     * @param WeekTraining $weekTraining
     */
    public function addWeekTrainings(WeekTraining $weekTraining)
    {
        $this->weekTrainings[] = $weekTraining;
    }
}
