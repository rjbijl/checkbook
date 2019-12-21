<?php

namespace AppBundle\Mutation;

use AppBundle\Entity\Mutation;
use AppBundle\Repository\MutationRepository;
use Doctrine\ORM\EntityManager;

class IngImporter implements ImporterInterface
{
    use ImporterTrait;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var MutationRepository
     */
    private $mutationRepository;

    /**
     * IngImporter constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->mutationRepository = $em->getRepository(Mutation::class);
    }

    /**
     * {@inheritdoc}
     */
    public function processFile(string $filename) : bool
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
        $identifier = md5(sprintf('%s-%s', $data[0], $data[8]));
        $mutation = $this->getCreateMutation($this->mutationRepository, $data[2], $identifier);

        $mutation->setAmount(str_replace(',','.',$data[6]) * 100);
        $mutation->setDate(\DateTimeImmutable::createFromFormat('Ymd', $data[0]));
        $mutation->setType('Af' === $data[5] ? Mutation::TYPE_CREDIT : Mutation::TYPE_DEBIT);
        $mutation->setDescription($data[8]);
        $mutation->setContraAccountName($data[1]);
        $mutation->setContraAccountNumber($data[3]);

        return $mutation;
    }
}