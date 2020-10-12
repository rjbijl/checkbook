<?php

namespace AppBundle\Mutation;

/**
 * Interface ImporterInterface
 * @package AppBundle\Mutation
 */
interface ImporterInterface
{
    /**
     * Process a file, create a set of Mutations
     *
     * @param string $filename
     * @return bool
     */
    public function processFile(string $filename) : bool;
}