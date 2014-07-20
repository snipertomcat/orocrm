<?php

namespace Stc\Bundle\ContractBundle\Model\Generator;

use Stc\Bundle\ContractBundle\Entity\Contract;

class ContractGenerator
{
    protected $contract;

    protected $template;

    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
        $this->template = 'StcContractBundle:ContractTemplate:' . $this->contract->getContractType() . '.html.twig';
    }

    protected function generate()
    {

    }

}