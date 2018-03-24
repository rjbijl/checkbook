<?php

namespace AppBundle\Command;

use AppBundle\Entity\Mutation;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportMutationsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ImportMutationsCommand')
            ->setDescription('Import mutations from a bank export')
            ->addArgument('filename', InputArgument::REQUIRED, 'The file to import');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = fopen($input->getArgument('filename'), 'r');
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        while ($data = fgetcsv($file)) {
            if ('Datum' === $data[0]) {
                continue;
            }

            $mutation = new Mutation();
            $mutation->setAmount(str_replace(',','.',$data[6]) * 100);
            $mutation->setDatetime(\DateTimeImmutable::createFromFormat('Ymd', $data[0]));
            $mutation->setType('Af' === $data[5] ? Mutation::TYPE_CREDIT : Mutation::TYPE_DEBIT);
            $mutation->setDescription($data[8]);
            $mutation->setContraAccountName($data[1]);
            $mutation->setContraAccountNumber($data[3   ]);

            $em->persist($mutation);
        }

        $em->flush();
        $output->writeln('Command result.');
        exit(0);
    }
}
