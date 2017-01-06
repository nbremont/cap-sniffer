<?php

namespace Tests\Cp\Provider;

use Cp\DomainObject\TypeInterface;
use Cp\Provider\TypeProvider;

/**
 * Class TypeProviderTest
 */
class TypeProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if types are right
     */
    public function testGetTypes()
    {
        $typeProvider = new TypeProvider();

        $expected = [
            '10' => 'plan-entrainement-10km',
            '21' => 'plan-entrainement-semi-marathon',
            '42' => 'plan-entrainement-marathon',
        ];

        $this->assertEquals($expected, $typeProvider->getTypes());
    }

    /**
     * Test return type available by name
     */
    public function testGetTypeByName()
    {
        $typeProvider = new TypeProvider();

        $this->assertEquals('10', $typeProvider->getTypeByName('plan-entrainement-10km'));
        $this->assertEquals('21', $typeProvider->getTypeByName('plan-entrainement-semi-marathon'));
        $this->assertEquals('42', $typeProvider->getTypeByName('plan-entrainement-marathon'));
    }

    /**
     * Test return type available by name
     *
     * @expectedException Exception
     */
    public function testGetTypeByNameNotFound()
    {
        $typeProvider = new TypeProvider();

        $this->assertEquals('10', $typeProvider->getTypeByName('plan-fake-and-wrong'));
    }

    /**
     * Test return type available by key
     */
    public function testGetTypeByKey()
    {
        $typeProvider = new TypeProvider();

        $this->assertEquals(TypeInterface::TYPE_10K, $typeProvider->getTypeByKey(10));
    }

    /**
     * Test return type available by key
     *
     * @expectedException Exception
     */
    public function testGetTypeByKeyNotFound()
    {
        $typeProvider = new TypeProvider();

        $this->assertEquals(TypeInterface::TYPE_10K, $typeProvider->getTypeByKey(99));
    }
}
