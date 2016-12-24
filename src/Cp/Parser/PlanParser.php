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
     * @throws \Exception
     */
    public function loadContent($url)
    {
        $htmlContent = file_get_contents($url);
        if (false === $htmlContent) {
            throw new \Exception(sprintf('Content can not be get from %s', $url));
        }

        $this->parser->load($htmlContent);
    }

    /**
     * @param string $url
     *
     * @return string
     * @throws \Exception
     */
    public function parseToJson($url)
    {
        $this->loadContent($url);
        $weeks = $this->parser->find('#plans table');
        if (0 >= $weeks->count()) {
            throw new \Exception(sprintf('Plan not found for this url: %s', $url));
        }

        $plan = $this->getPlan();
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

    /**
     * @param string $url
     *
     * @return string
     * @throws \Exception
     */
    public function parseToHtml($url)
    {
        $this->loadContent($url);

        return sprintf('%s%s%s', '<table>', $this->parser->find('#plans table')->innerHtml, '</table>');
    }

    /**
     * @return array
     */
    private function getPlan()
    {
        $nameOfPlan = strip_tags($this->parser->find('.article-content-main h1')->innerHtml);
        $typeOfPlan = strip_tags($this->parser->find('.article-content-main h3')->innerHtml);

        return [
            'name' => strip_tags($nameOfPlan),
            'type' => strip_tags($typeOfPlan),
            'weeks' => [],
        ];
    }
}
