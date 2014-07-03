<?php

namespace Stc\Bundle\PerformanceBundle\Entity;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Util\SecureRandomInterface;

use Stc\Bundle\VenueBundle\Entity\Venue;
use Stc\Bundle\BandBundle\Entity\Band;

/**
 * Class PerformanceManager
 * Handles Performance Persist
 * @package Stc\Bundle\PerformanceBundle\Entity
 */
class PerformanceManager
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createPerformance(Performance $performance)
    {
        $venue = $performance->getVenue();
        $bands = $performance->getBands();

        print_r($performance);exit;
    }
}
