<?php

namespace Cp\Parser;

use PHPHtmlParser\Dom;

class CpParser
{
    /**
     * @var Dom
     */
    private $parser;

    /**
     * @var string
     */
    private $url;

    /**
     * CpParser constructor.
     *
     * @param Dom    $parser
     * @param string $url
     */
    public function __construct(Dom $parser, $url)
    {
        $this->parser = $parser;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function parseToJson()
    {
        $htmlContent = file_get_contents($this->url);

        $dom = new Dom();
        $dom->load($htmlContent);

        $weeks = $dom->find('#plans table');

        $stdPlanObj = new \stdClass();
        $stdPlanObj->name = "Plan";

        foreach ($weeks as $training) {
            $stdWeekObj = new \stdClass();
            $stdWeekObj->name = $training->find('thead tr')->find('td')[1]->innerHtml;
            foreach ($training->find('tbody tr') as $seance) {
                $stdTrainingObj = new \stdClass();
                $stdTrainingObj->type = $seance->find('td')[0]->innerHtml;
                $stdTrainingObj->content = $seance->find('td')[1]->innerHtml;
                $stdWeekObj->trainings[] = $stdTrainingObj;
            }
            $stdPlanObj->weekTrainings[] = $stdWeekObj;
        }

        return json_encode($stdPlanObj, true);
    }
}
