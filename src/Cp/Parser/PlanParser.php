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
        $this->generateBadRequestException($url);

        $this->parser->load($htmlContent);

        $weeks = $this->parser->find('#plans table');
        if (empty($weeks)) {
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
        $htmlContent = file_get_contents($url);
        $this->generateBadRequestException($url);

        $this->parser->load($htmlContent);

        return $this->parser->find('#plans table')->innerHtml;
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

    /**
     * @param string $url
     *
     * @throws \Exception
     */
    private function generateBadRequestException($url)
    {
        if (isset($http_response_header)) {
            $responseCode = $this->headerParser->get('response_code', $http_response_header);
            if ('200' != $responseCode) {
                throw new \Exception(
                    sprintf('Url %s return http response code %s', $url, $responseCode),
                    $responseCode
                );
            }
        }
    }
}
