<?php

namespace Cp\DomainObject;

use JMS\Serializer\Annotation as JMS;

class WeekTraining
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
     * @JMS\Type("array<Cp\DomainObject\Training>")
     */
    private $trainings;

    /**
     * WeekTraining constructor.
     */
    public function __construct()
    {
        $this->trainings = [];
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
    public function getTrainings()
    {
        return $this->trainings;
    }

    /**
     * @param Training $training
     */
    public function addTraining(Training $training)
    {
        $this->trainings[] = $training;
    }
}
