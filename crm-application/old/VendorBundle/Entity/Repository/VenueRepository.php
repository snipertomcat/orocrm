<?php

namespace Stc\Bundle\VendorBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Stc\Bundle\VendorBundle\Entity\Venue;

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