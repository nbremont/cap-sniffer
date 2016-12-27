<?php

namespace Tests\Cp\Parser;

use Cp\Parser\PlanParser;
use PHPHtmlParser\Dom;
use stringEncode\Exception;

/**
 * Class PlanParserTest
 */
class PlanParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test parse html to json object
     */
    public function testParseToJson()
    {
        $url = __DIR__.'/../../fixtures/html/Plan-10km-3-seances-6semaines.htm';
        $planParser = new PlanParser(new Dom());

        $expected = [
            'name' => 'Plans entrainement 10 km en 50 / 55 minutes',
            'type' => 'Plan 10 km avec 3 séances sur 6 semaines',
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
                            'content' => 'Footing de 20-30 minutes suivi de 2 séries de 30"-30" à 100-105%VMA avec 3 minutes de récupération entre chaque série.',
                        ],
                        [
                            'type' => 'SL-80/85',
                            'content' => 'Sortie longue de 1h20 dont 2 fois 10minutes à 80-85%FCM avec une récupération de 2 minutes entre chaque effort',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals(json_encode($expected), $planParser->parseToJson($url));
    }

    /**
     * @expectedException Exception
     */
    public function testParseToJsonWithException()
    {
        $url = __DIR__.'/../../fixtures/html/wrong-page.htm';
        $planParser = new PlanParser(new Dom());

        $planParser->parseToJson($url);
    }

    /**
     * Test to parse plan on Html
     */
    public function testParseToHtml()
    {
        $url = __DIR__.'/../../fixtures/html/Plan-10km-3-seances-6semaines.htm';
        $planParser = new PlanParser(new Dom());

        $htmlContent = '<table>
            <thead>
                <tr>
                    <td>&nbsp;</td>
                    <td class="semaine">Semaine 1</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fonce">EF</td>
                    <td>Footing de <strong>45 minutes</strong></td>
                </tr>
                <tr>
                    <td class="fonce">VMA-105</td>
                    <td>Footing de 20-30 minutes suivi de <strong>2 séries de 30"-30" à 100-105%VMA</strong> avec 3 minutes de récupération entre chaque série.</td>
                </tr>
                <tr>
                    <td class="fonce">SL-80/85</td>
                    <td>Sortie longue de <strong>1h20</strong> dont <strong>2 fois 10minutes à 80-85%FCM</strong> avec une récupération de 2 minutes entre chaque effort</td>
                </tr>
            </tbody>
        </table>';

        $expected = preg_replace('/>([\t|\s]+)</', '><', $htmlContent);
        $actual = preg_replace('/>([\t|\s]+)</', '><', $planParser->parseToHtml($url));

        $this->assertEquals($expected, $actual);
    }
}
