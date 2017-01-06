<?php

namespace Cp\Command;

use Cp\CapSniffer;
use Cp\Provider\TypeProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Class SnifferTrainingCommand
 */
class SnifferTrainingCommand extends Command
{
    const FILE_NAME = 'planning.ics';

    /**
     * @var TypeProvider
     */
    private $typeProvider;

    /**
     * @var CapSniffer
     */
    private $capSniffer;

    /**
     * SnifferTrainingCommand constructor.
     *
     * @param TypeProvider $typeProvider
     * @param CapSniffer   $capSniffer
     * @param null|string  $name
     */
    public function __construct(TypeProvider $typeProvider, CapSniffer $capSniffer, $name = null)
    {
        parent::__construct($name);
        $this->typeProvider = $typeProvider;
        $this->capSniffer = $capSniffer;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('cp:sniffer')
            ->setDescription('Get training plan by url')
            ->addArgument('week', InputArgument::OPTIONAL, 'Number of week', 8)
            ->addArgument('seance', InputArgument::OPTIONAL, 'Number of seance', 3)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $week = $input->getArgument('week');
        $seance = $input->getArgument('seance');

        $typeOfPlan = $this->typeProvider->getTypes();
        $question = new ChoiceQuestion('Please select a plan', $typeOfPlan, 0);
        $question->setErrorMessage('Plan %s is not valid.');

        $helper = $this->getHelper('question');
        $type = $helper->ask($input, $output, $question);
        $typeKey = $this->typeProvider->getTypeByName($type);

        $this->capSniffer->writeCalendar($typeKey, $week, $seance);

        $output
            ->writeln(sprintf(
                'Calendar generate successfully in <info>%s</info>',
                $this->capSniffer->getFileName($typeKey, $week, $seance)
            ));
    }
}
