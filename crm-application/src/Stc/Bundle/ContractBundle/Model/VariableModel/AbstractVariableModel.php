<?php

namespace Stc\Bundle\ContractBundle\Model\VariableModel;

abstract class AbstractVariableModel
{
    protected $vars = [];

    abstract public function setVars($vars = array());

    abstract public function getVars();
}