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
            '10' => 'plan-entrainement-10km',
            '21' => 'plan-entrainement-semi-marathon',
            '42' => 'plan-entrainement-marathon',
        ];

        $this->assertEquals($expected, $typeProvider->getTypes());
    }

    /**
     * Test return type available
     */
    public function testGetType()
    {
        $typeProvider = new TypeProvider();

        $this->assertEquals('plan-entrainement-10km', $typeProvider->getTypeByName('plan-entrainement-10km'));
        $this->assertEquals('plan-entrainement-semi-marathon', $typeProvider->getTypeByName('plan-entrainement-semi-marathon'));
        $this->assertEquals('plan-entrainement-marathon', $typeProvider->getTypeByName('plan-entrainement-marathon'));

        $this->assertEquals(null, $typeProvider->getTypeByName('fake'));
    }
}
