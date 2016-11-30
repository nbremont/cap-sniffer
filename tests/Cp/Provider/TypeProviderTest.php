<?php

namespace Tests\Cp\Provider;

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
            'plan-entrainement-10km',
            'plan-entrainement-semi-marathon',
            'plan-entrainement-marathon',
        ];

        $this->assertEquals($expected, $typeProvider->getTypes());
    }

    /**
     * Test return type available
     */
    public function testGetType()
    {
        $typeProvider = new TypeProvider();

        $this->assertEquals('plan-entrainement-10km', $typeProvider->getType('plan-entrainement-10km'));
        $this->assertEquals('plan-entrainement-semi-marathon', $typeProvider->getType('plan-entrainement-semi-marathon'));
        $this->assertEquals('plan-entrainement-marathon', $typeProvider->getType('plan-entrainement-marathon'));

        $this->assertEquals(null, $typeProvider->getType('fake'));
    }
}
