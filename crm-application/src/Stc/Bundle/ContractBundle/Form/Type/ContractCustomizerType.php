<?php

namespace Stc\Bundle\ContractBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use Stc\Bundle\ContractBundle\Model\VariableModel\AbstractVariableModel;

class ContractCustomizerType extends AbstractType
{

    protected $variableModelVars;

    public function __construct($variableModelVars = null)
    {
        $this->variableModelVars = $variableModelVars;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->variableModelVars as $key=>$val) {
            $builder->add(
                $key, 'text', [
                'required' => false
            ]);
        }

    }

    /**
     * @inheritdoc
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'stc_contract_editor';
    }
}