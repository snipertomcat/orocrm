<?php

namespace Stc\Bundle\ContractBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Stc\Bundle\ContractBundle\Entity\ContractStatus;

class ContractRepository extends EntityRepository
{
    /**
     * @return integer
     */
    public function getContractCountByStage()
    {
        return $this->createQueryBuilder('contract')
            ->select('COUNT(contract)')
            ->from('StcContractBundle:Contract')
            ->orderBy('stage')
            ->getQuery()
            ->getSingleScalarResult();
    }
}