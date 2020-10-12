<?php

namespace AppBundle\Mutation;

use AppBundle\Entity\Mutation;
use AppBundle\Repository\MutationRepository;
use Doctrine\ORM\EntityManager;

class RaboImporter implements ImporterInterface
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
     * RaboImporter constructor.
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
            if ('IBAN/BBAN' === $data[0]) {
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
        $mutation = $this->getCreateMutation($this->mutationRepository, $data[0], $data[3]);

        $amount = (float) str_replace(',','.',$data[6]);
        $mutation->setAmount(abs($amount) * 100);
        $mutation->setDate(\DateTimeImmutable::createFromFormat('Y-m-d', $data[4]));
        $mutation->setType($amount < 0 ? Mutation::TYPE_CREDIT : Mutation::TYPE_DEBIT);
        $mutation->setDescription($this->mergeDescriptions($data));
        $mutation->setContraAccountName($data[9]);
        $mutation->setContraAccountNumber($data[8]);

        return $mutation;
    }

    /**
     * Merge the description fields into one field
     *
     * @param array $data
     * @return string
     */
    private function mergeDescriptions(array $data): string
    {
        $description = trim($data[19]);

        $extraDescription = trim($data[20]);
        if (!empty($extraDescription)) {
            $description = sprintf('%s ; %s', $description, $extraDescription);
        }

        $extraDescription = trim($data[21]);
        if (!empty($extraDescription)) {
            $description = sprintf('%s ; %s', $description, $extraDescription);
        }

        return $description;
    }
}