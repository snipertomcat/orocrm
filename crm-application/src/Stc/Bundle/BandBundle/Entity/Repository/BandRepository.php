<?php

namespace Stc\Bundle\BandBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Stc\Bundle\BandBundle\Entity\BandStatus;

class BandRepository extends EntityRepository
{
    /**
     * @param BandStatus $status
     * @return integer
     */
    public function getBandCountByStatus(BandStatus $status)
    {
        return $this->createQueryBuilder('band')
            ->select('COUNT(band)')
            ->where('band.status = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getSingleScalarResult();
    }
}