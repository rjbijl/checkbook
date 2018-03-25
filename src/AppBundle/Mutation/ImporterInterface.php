<?php

namespace AppBundle\Mutation;

use AppBundle\Entity\Mutation;
use Doctrine\ORM\EntityManager;

class IngImporter
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * IngImporter constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function processFile(string $filename)
    {
        $file = fopen($filename, 'r');
        while ($data = fgetcsv($file)) {
            if ('Datum' === $data[0]) {
                continue;
            }

            $mutation = $this->createMutationFromDataArray($data);
            $this->em->persist($mutation);
        }

        fclose($file);

        try {
            $this->em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param array $data
     * @return Mutation
     */
    private function createMutationFromDataArray(array $data): Mutation
    {
        $mutation = new Mutation();

        $mutation->setAmount(str_replace(',','.',$data[6]) * 100);
        $mutation->setDate(\DateTimeImmutable::createFromFormat('Ymd', $data[0]));
        $mutation->setType('Af' === $data[5] ? Mutation::TYPE_CREDIT : Mutation::TYPE_DEBIT);
        $mutation->setDescription($data[8]);
        $mutation->setContraAccountName($data[1]);
        $mutation->setContraAccountNumber($data[3]);

        return $mutation;
    }
}