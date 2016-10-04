<?php

namespace Cp\DomainObject;

use JMS\Serializer\Annotation as JMS;

class Week
{
    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @var array
     *
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

    /**
     * @return string
     */
    public function __toString()
    {
        $stream = $this->getName()."\n";
        foreach ($this->getTrainings() as $training) {
            $stream .= (string) $training;
        }

        return $stream;
    }
}
