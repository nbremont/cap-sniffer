<?php

namespace Cp\Command;

use Cp\Parser\CpParser;
use JMS\Serializer\SerializerBuilder;
use PHPHtmlParser\Dom;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SnifferTrainingCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('cp:sniffer')
            ->setDescription('Get training plan by url')
            ->addArgument('url', InputArgument::REQUIRED, 'Url of plan.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');

        $dom = new Dom();
        $parser = new CpParser($dom, $url);
        $jsonString = $parser->parseToJson();

        $serializer = SerializerBuilder::create()->build();
        $plan = $serializer->deserialize($jsonString, 'Cp\DomainObject\Plan', 'json');

        $output->writeln($plan->getName());
        $output->writeln($plan->getType());
    }
}