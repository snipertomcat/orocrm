<?php

namespace Stc\Bundle\MapBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

use Stc\Bundle\MapBundle\Entity\MapStatus;
use Symfony\Component\Config\Definition\Exception\Exception;

class MapRepository extends EntityRepository
{
    /**
     * @return integer
     */
    public function getMap($map)
    {

    }

}