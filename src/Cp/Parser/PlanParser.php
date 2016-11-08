<?php

namespace Cp\Parser;

use Cp\Http\HeaderParser;
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
     * @var HeaderParser
     */
    private $headerParser;

    /**
     * CpParser constructor.
     *
     * @param Dom          $parser
     * @param HeaderParser $headerParser
     */
    public function __construct(Dom $parser, HeaderParser $headerParser)
    {
        $this->parser = $parser;
        $this->headerParser = $headerParser;
    }

    /**
     * @param string $url
     *
     * @return string
     * @throws \Exception
     */
    public function parseToJson($url)
    {
        $htmlContent = file_get_contents($url);
        if (200 !== $responseCode = $this->headerParser->get('response_code', $http_response_header)) {
            throw new \Exception(sprintf('Url %s return http response code %s', $url, $responseCode), $responseCode);
        }

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
