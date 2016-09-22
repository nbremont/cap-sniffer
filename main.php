<?php

require_once './vendor/autoload.php';

use PHPHtmlParser\Dom;
use Doctrine\Common\Annotations\AnnotationRegistry;

AnnotationRegistry::registerLoader('class_exists');

$url = 'http://www.conseils-courseapied.com/plan-entrainement/plan-entrainement-10km/3-seances-6-semaines.html';
$contentHtml = file_get_contents($url);

$dom = new Dom();
$parser = new \Cp\Parser\CpParser($dom, $url);
$jsonString = $parser->parseToJson();

$serializer = JMS\Serializer\SerializerBuilder::create()->build();
$plan = $serializer->deserialize($jsonString, 'Cp\DomainObject\PlanTraining', 'json');

var_dump($plan);

exit(0);
