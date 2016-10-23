<?php

namespace Cp\Parser;

use PHPHtmlParser\Dom;

class PlanParser
{
    /**
     * @var Dom
     */
    private $parser;

    /**
     * CpParser constructor.
     *
     * @param Dom $parser
     */
    public function __construct(Dom $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function parseToJson($url)
    {
        $htmlContent = file_get_contents($url);

        $dom = new Dom();
        $dom->load($htmlContent);

        $nameOfPlan = strip_tags($dom->find('.article-content-main h1')->innerHtml);
        $typeOfPlan = strip_tags($dom->find('.article-content-main h3')->innerHtml);
        $weeks = $dom->find('#plans table');

        $plan = [
            'name' => $nameOfPlan,
            'type' => $typeOfPlan,
            'weeks' => [],
        ];

        foreach ($weeks as $training) {
            $week = ['name' => $training->find('thead tr')->find('td')[1]->innerHtml];
            foreach ($training->find('tbody tr') as $seance) {
                $training = [
                    'type' => $seance->find('td')[0]->innerHtml,
                    'content' => $seance->find('td')[1]->innerHtml,
                ];
                $week['trainings'][] = $training;
            }
            $plan['weeks'][] = $week;
        }

        return json_encode($plan, true);
    }
}
