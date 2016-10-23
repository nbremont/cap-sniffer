<?php


namespace Tests\Cp\Parser;

use Cp\Parser\PlanParser;
use PHPHtmlParser\Dom;

/**
 * Class PlanParserTest
 */
class PlanParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseToJson()
    {
        $url = __DIR__.'/../../fixtures/html/Plan-10km-3-seances-6semaines.htm';
        $planParser = new PlanParser(new Dom());

        $expected = [
            'name' => 'Plans entrainement 10 km en 50 / 55 minutes',
            'type' => 'Plan 10 km avec 3 séances / 6 semaines',
            'weeks' => [
                [
                    'name' => 'Semaine 1',
                    'trainings' => [
                        [
                            'type' => 'EF',
                            'content' => 'Footing de 45 minutes',
                        ],
                        [
                            'type' => 'VMA-105',
                            'content' => 'Footing de 20-30 minutes suivi de 2 séries de 30"-30" à 100-105%VMA avec 3 '
                                .'minutes de récupération entre chaque série.',
                        ],
                        [
                            'type' => 'SL-80/85',
                            'content' => 'Sortie longue de 1h20 dont 2 fois 10minutes à 80-85%FCM avec une récupération'
                                .' de 2 minutes entre chaque effort',
                        ],
                    ],
                ],
            ]
        ];

        $this->assertEquals(json_encode($expected), $planParser->parseToJson($url));
    }
}
