<?php

namespace Tests\Cp\Transformer;

use Cp\Transformer\UrlTransformer;

class UrlTransformerTest  extends \PHPUnit_Framework_TestCase
{
    public function testTransform()
    {
        $urlTransformer = new UrlTransformer('http://www.conseils-courseapied.com', [
            'plan-entrainement-10km',
            'semi-marathon',
            'marathon'
        ]);

        $expected = 'http://www.conseils-courseapied.com/plan-entrainement/'
            .'plan-entrainement-10km/3-seances-6-semaines.html';

        $this->assertEquals($expected, $urlTransformer->transformPlan(6, 3, 'plan-entrainement-10km'));
    }
}
