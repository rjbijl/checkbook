<?php

namespace AppBundle\Model;

use AppBundle\Entity\Category;

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
     * @var Category
     */
    private $category;

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
    public function setStartDate(\DateTimeInterface $startDate = null): MutationFilter
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
    public function setEndDate(\DateTimeInterface $endDate = null): MutationFilter
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return MutationFilter
     */
    public function setCategory(Category $category = null): MutationFilter
    {
        $this->category = $category;
        return $this;
    }
}