<?php

declare(strict_types=1);

namespace App\Sales\Command;

use App\Sales\SalesGenerator\SalesGeneratorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateSalesCommand extends Command
{
    private const CONSUMERS_COUNT = 50;
    private const SALES_COUNT_PER_CONSUMER = 50;

    /** @var string */
    protected static $defaultName = 'app:generate-sales';
    private SalesGeneratorInterface $salesGenerator;

    public function __construct(SalesGeneratorInterface $salesGenerator)
    {
        $this->salesGenerator = $salesGenerator;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Fact sales generating');
        for ($i = 0; $i < self::CONSUMERS_COUNT; ++$i) {
            $this->salesGenerator->generate(self::SALES_COUNT_PER_CONSUMER);
            $output->write('.');
        }
        $output->writeln('Completed!');
    }
}
