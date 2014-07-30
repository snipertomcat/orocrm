<?php

namespace Stc\Bundle\MapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Stc\Bundle\MapBundle\Entity\Map;
//use Stc\Bundle\MapBundle\Model\VariableModel\AbstractVariableModel;

class MapType extends AbstractType
{
    protected $mapClass;

    public function __construct($mapClass = 'Stc\Bundle\MapBundle\Entity\MapType')
    {
        $this->mapClass = $mapClass;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            'text',
            [
                'label' => 'stc.map.name.label',
                'required' => true,
            ])
        ->add(
            'owner',
            'oro_user_select', [
            'required' => false,
            'label' => 'stc.map.owner.label'
        ])
        ->add(
            'mapType',
            'text',
            [
                'label' => 'stc.map.mapType.label',
                'required' => false,
            ])
        ->add(
            'deleted',
            'boolean',
             [
                 'label' => 'stc.map.deleted.label',
                 'required' => false
             ])
        ->add(
            'coordinate',
            'entity',
            [
                'required' => true,
                'class' => 'StcMapBundle:Map',
                'property' => 'name',
                'multiple' => true,
                'expanded' => false
            ]
            )
        ->add(
            'createdAt', 'oro_date', [
            'required' => false, 'label' => 'stc.map.createdAt.label'
        ])
        ->add(
            'updatedAt', 'oro_date', [
            'required' => false, 'label' => 'stc.map.updatedAt.label'
        ]);

    }

    /**
     * @inheritdoc
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => $this->mapClass
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'stc_map';
    }
}