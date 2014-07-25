<?php

namespace Stc\Bundle\ContractBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContractType extends AbstractType
{
    /**
     * @var string
     */
    protected $contractClass;

    /**
     * @param string $contractClass
     */
    public function __construct($contractClass = 'Stc\Bundle\ContractBundle\Entity\Contract')
    {
        $this->contractClass = $contractClass;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name', 'text', [
            'required' => false, 'label' => 'stc.contract.name.label'
        ])
            ->add(
                'location', 'text', [
                'required' => false, 'label' => 'stc.contract.location.label'
            ])
            ->add(
                'performance', 'entity', [
                'required' => true, 'class' => 'StcPerformanceBundle:Performance', 'property' => 'name', 'multiple' => false, 'expanded' => false, 'label' => 'stc.contract.performance.label'
            ])
            ->add(
                'assignee', 'oro_user_select', [
                'required' => false, 'label' => 'stc.contract.assignee.label'
            ])
            ->add(
                'owner', 'oro_user_select', [
                'required' => false, 'label' => 'stc.contract.owner.label'
            ])
            ->add(
                'stage', 'choice', [
                'required' => false, 'choices' => [
                    'created' => 'Created', 'sent' => 'Sent', 'finalized' => 'Finalized'
                ],
                'label' => 'stc.contract.stage.label'
            ])
            ->add(
                'contractType', 'choice', [
                'required' => false, 'choices' => [
                    'SBNT' => 'Single Band, No Travel', 'SBWT' => 'Single Band, With Travel', 'MBNT' => 'Multi Band, No Travel', 'MBWT' => 'Multi Band, With Travel'
                ]
                , 'label' => 'stc.contract.contractType.label'
            ])
            ->add(
                'isSigned', 'choice', [
                'required' => false, 'choices' => [
                    'Y' => 'Yes',
                    'N' => 'No'
                ],
                'expanded' => false, 'label' => 'stc.contract.isSigned.label', 'disabled' => true
            ])
            ->add(
                'signedAt', 'oro_date', [
                'required' => false, 'label' => 'stc.contract.signedAt.label'
            ])
            ->add(
                'createdAt', 'oro_date', [
                'required' => false, 'label' => 'stc.contract.createdAt.label'
            ])
            ->add(
                'updatedAt', 'oro_date', [
                'required' => false, 'label' => 'stc.contract.updatedAt.label'
            ]);
    }

    /**
     * @inheritdoc
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => $this->contractClass
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'stc_contract';
    }
}