<?php

namespace AppBundle\Model;

class MutationFilter
{
    /**
     * @var \DateTimeInterface
     */
    private $startDate;

    /**
     * @var \DateTimeInterface
     */
    private $endDate;

    /**
     * @return \DateTimeInterface
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTimeInterface $startDate
     * @return MutationFilter
     */
    public function setStartDate(\DateTimeInterface $startDate): MutationFilter
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTimeInterface $endDate
     * @return MutationFilter
     */
    public function setEndDate(\DateTimeInterface $endDate): MutationFilter
    {
        $this->endDate = $endDate;
        return $this;
    }
}