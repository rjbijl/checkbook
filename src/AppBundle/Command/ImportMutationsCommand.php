<?php

namespace AppBundle\Command;

use AppBundle\Mutation\ImporterInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportMutationsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ImportMutationsCommand')
            ->setDescription('Import mutations from a bank export')
            ->addArgument('filename', InputArgument::REQUIRED, 'The file to import')
            ->addArgument('type', InputArgument::REQUIRED, 'The type of file to import (ing|rabo)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ImporterInterface $importer */
        $importer = $this->getContainer()->get(sprintf('app.mutation.importer_%s', $input->getArgument('type')));
        $importer->processFile($input->getArgument('filename'));

        $output->writeln(sprintf('<info>Processed file %s</info>', $input->getArgument('filename')));
        exit(0);
    }
}
