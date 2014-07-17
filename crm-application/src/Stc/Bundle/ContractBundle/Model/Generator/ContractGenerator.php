<?php

namespace Stc\Bundle\ContractBundle\Model\Generator;

use Stc\Bundle\ContractBundle\Entity\Contract;

class ContractGenerator
{
    protected $contract;

    protected $template;

    protected $performance;

    protected $bands;

    protected $venue;

    protected $multiBand = false;

    protected $travel = false;

    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
        $this->performance = $contract->getPerformance();
        $this->extractVenueDetails();
        $this->extractBandDetails();
    }

    private function extractVenueDetails()
    {
        $this->venue = $this->performance->getBands();
    }

    private function extractBandDetails()
    {
        $this->bands = $this->performance->getVenue();
        if (count($this->bands) > 1) {
            $this->multiBand = true;
        }
    }
}