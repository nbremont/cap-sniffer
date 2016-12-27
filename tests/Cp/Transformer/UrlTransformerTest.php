<?php

namespace Tests\Cp\Transformer;

use Cp\DomainObject\TypeInterface;
use Cp\Transformer\UrlTransformer;

/**
 * Class UrlTransformerTest
 */
class UrlTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test transform url for plan
     */
    public function testTransform()
    {
        $urlTransformer = new UrlTransformer('http://www.conseils-courseapied.com');

        $expected = 'http://www.conseils-courseapied.com/plan-entrainement/'
            .'plan-entrainement-10km/3-seances-6-semaines.html';

        $this->assertEquals($expected, $urlTransformer->transformPlan(6, 3, 'plan-entrainement-10km'));
    }

    /**
     * Test transform url for type of plan
     */
    public function testTransformType()
    {
        $expected = 'http://www.conseils-courseapied.com/plan-entrainement/plan-entrainement-10km.html';
        $urlTransformer = new UrlTransformer('http://www.conseils-courseapied.com');

        $this->assertEquals($expected, $urlTransformer->transformType(TypeInterface::TYPE_10K));
    }

    /**
     *
     */
    public function testReverseConfiguration()
    {
        $urlTransformer = new UrlTransformer('http://www.conseils-courseapied.com');
        $urlTypeOfPlan = 'http://www.conseils-courseapied.com/plan-entrainement/'
            .'plan-entrainement-10km/3-seances-6-semaines.html';

        $urlTypeOfPlanWrong = 'http://www.conseils-courseapied.com/plan-entrainement/plan-reprise-course-a-pied.html';

        $expected = [
            'seance' => 3,
            'week' => 6,
        ];

        $this->assertEquals($expected, $urlTransformer->reverseConfiguration($urlTypeOfPlan));
        $this->assertEquals(null, $urlTransformer->reverseConfiguration($urlTypeOfPlanWrong));
    }
}
