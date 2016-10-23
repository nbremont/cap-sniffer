<?php

namespace Cp\Parser;

use PHPHtmlParser\Dom;

/**
 * Class PlanParser
 */
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
        $this->parser->load($htmlContent);

        $nameOfPlan = strip_tags($this->parser->find('.article-content-main h1')->innerHtml);
        $typeOfPlan = strip_tags($this->parser->find('.article-content-main h3')->innerHtml);
        $weeks = $this->parser->find('#plans table');

        $plan = [
            'name' => strip_tags($nameOfPlan),
            'type' => strip_tags($typeOfPlan),
            'weeks' => [],
        ];

        foreach ($weeks as $training) {
            $week = ['name' => $training->find('thead tr')->find('td')[1]->innerHtml];
            foreach ($training->find('tbody tr') as $seance) {
                $training = [
                    'type' => strip_tags($seance->find('td')[0]->innerHtml),
                    'content' => strip_tags($seance->find('td')[1]->innerHtml),
                ];
                $week['trainings'][] = $training;
            }
            $plan['weeks'][] = $week;
        }

        return json_encode($plan, true);
    }
}
