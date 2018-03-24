<?php

namespace AppBundle\Repository;

use AppBundle\Model\MutationFilter;
use Doctrine\ORM\EntityRepository;

class MutationRepository extends EntityRepository
{
    /**
     * @param MutationFilter $filter
     * @return array
     */
    public function findWithFilter(MutationFilter $filter) :array
    {
        $qb = $this->createQueryBuilder('m')
            ->orderBy('m.date', 'ASC')
        ;
        
        if ($startDate = $filter->getStartDate()) {
            $qb->andWhere('m.date >= :startDate')
                ->setParameter('startDate', $filter->getStartDate())
            ;
        }
        
        if ($endDate = $filter->getEndDate()) {
            $qb->andWhere('m.date <= :endDate')
                ->setParameter('endDate', $filter->getEndDate())
            ;
        }

        if ($category = $filter->getCategory()) {
            $qb->andWhere('m.category = :category')
                ->setParameter('category', $filter->getCategory())
            ;
        }

        return $qb->getQuery()->getResult();
    }
}