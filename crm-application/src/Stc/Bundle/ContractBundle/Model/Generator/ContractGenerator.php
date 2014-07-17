<?php

namespace Stc\Bundle\ContractBundle\Model\Generator;

use Stc\Bundle\ContractBundle\Entity\Contract;

class ContractGenerator
{
    protected $contract;

    protected $template;

    protected $multiBand = false;

    protected $travel = false;

    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
        $this->extractDataValues();
    }

    private function extractDataValues()
    {
        $this->travel = $this->contract->getTravel();
    }

    public function selectTemplate()
    {
        switch($this->$contract->getTravel()) {
            case 'MBWT':
                $this->
        }
    }

}