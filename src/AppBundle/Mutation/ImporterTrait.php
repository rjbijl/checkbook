<?php

namespace AppBundle\Mutation;

use AppBundle\Entity\Mutation;
use AppBundle\Repository\MutationRepository;

trait ImporterTrait
{
    /**
     * @param MutationRepository $repository
     * @param string $account
     * @param string $identifier
     * @return Mutation
     */
    public function getCreateMutation(MutationRepository $repository, string $account, string $identifier) : Mutation
    {
        if (!$mutation = $repository->findOneBy([
            'accountNumber' => $account,
            'identifier' => $identifier,
        ])) {
            $mutation = new Mutation();
            $mutation->setAccountNumber($account);
            $mutation->setIdentifier($identifier);
        }

        return $mutation;
    }
}