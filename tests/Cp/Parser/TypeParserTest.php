<?php

namespace Tests\Cp\Parser;

use Cp\Parser\TypeParser;
use PHPHtmlParser\Dom;

/**
 * Class TypeParserTest
 */
class TypeParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseToArray()
    {
        $url = __DIR__.'/../../fixtures/html/Plan-entrainement-debutant-10km-semi-marathon-trail.htm';
        $typeParser = new TypeParser(new Dom());

        $expected = [
            'debuter-debutant-entrainement-course-a-pied' => [
                'name' => 'Plans débutant',
                'url' => 'http://www.conseils-courseapied.com/plan-entrainement/debuter-debutant-entrainement-course-a-pied.html',
                'type' => 'debuter-debutant-entrainement-course-a-pied'
            ],
            'plan-entrainement-10km' => [
                'name' => 'Plans 10 km',
                'url' => 'http://www.conseils-courseapied.com/plan-entrainement/plan-entrainement-10km.html',
                'type' => 'plan-entrainement-10km'
            ],
            'plan-entrainement-semi-marathon' => [
                'name' => 'Plan entrainement semi',
                'url' => 'http://www.conseils-courseapied.com/plan-entrainement/plan-entrainement-semi-marathon.html',
                'type' => 'plan-entrainement-semi-marathon'
            ],
            'plan-entrainement-marathon' => [
                'name' => 'Plans marathon',
                'url' => 'http://www.conseils-courseapied.com/plan-entrainement/plan-entrainement-marathon.html',
                'type' => 'plan-entrainement-marathon'
            ],
            'trail' => [
                'name' => 'Plans entrainement trail ',
                'url' => 'http://www.conseils-courseapied.com/plan-entrainement/trail.html',
                'type' => 'trail'
            ],
            'plan-entrainement-cross-country' => [
                'name' => 'Plans cross-country',
                'url' => 'http://www.conseils-courseapied.com/plan-entrainement/plan-entrainement-cross-country.html',
                'type' => 'plan-entrainement-cross-country'
            ],
            'demi-fond' => [
                'name' => 'Plans demi-fond',
                'url' => 'http://www.conseils-courseapied.com/plan-entrainement/demi-fond.html',
                'type' => 'demi-fond'
            ],
            'classiques' => [
                'name' => 'Plans divers ',
                'url' => 'http://www.conseils-courseapied.com/plan-entrainement/classiques.html',
                'type' => 'classiques'
            ],
            'plan-trail' => [
                'name' => 'Plans course nature',
                'url' => 'http://www.conseils-courseapied.com/plan-entrainement/plan-trail.html',
                'type' => 'plan-trail'
            ],
        ];

        $this->assertEquals($expected, $typeParser->parseToArray($url));
    }
}
