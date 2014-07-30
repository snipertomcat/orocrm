<?php

namespace Stc\Bundle\MapBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

use Symfony\Component\Config\Definition\Exception\Exception;
use Stc\Bundle\MapBundle\Entity\Coordinate;

class CoordinateRepository extends EntityRepository
{
    /**
     * @return integer
     */
    public function getMap($map)
    {

    }

}