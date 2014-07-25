<?php

namespace Stc\Bundle\ContractBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

use Stc\Bundle\ContractBundle\Entity\ContractStatus;
use Symfony\Component\Config\Definition\Exception\Exception;

class ContractRepository extends EntityRepository
{
    /**
     * @return integer
     */
    public function getContractCountByStage()
    {

    }

    public function insertAssociatedPerformance($contract_id, $performance_id)
    {
        if ($contract_id !== null && $performance_id !== null) {
            $rsm = new ResultSetMapping();
            $sql = "INSERT INTO stc_contract_to_performance VALUES($performance_id, $contract_id)";
            $this->getEntityManager()->createNativeQuery($sql,$rsm);
        } else {
            throw new Exception('Unable to create association due to null contract_id or performance_id in insertAssociatedPerformance()');
        }
    }
}