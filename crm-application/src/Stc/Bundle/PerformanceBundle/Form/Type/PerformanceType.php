<?php

namespace Stc\Bundle\PerformanceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PerformanceType extends AbstractType
{
    /**
     * @var string
     */
    protected $performanceClass;

    /**
     * @param string $performanceClass
     */
    public function __construct($performanceClass = 'Stc\Bundle\PerformanceBundle\Entity\Performance')
    {
        $this->performanceClass = $performanceClass;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                'name',
                'text',
                array(
                    'label' => 'stc.performance.name.label',
                    'required' => true,
                )
            )
            ->add(
                'description',
                'text',
                array(
                    'label' => 'stc.performance.description.label',
                    'required' => false,
                )
            )
            ->add(
                'contacts',
                'orocrm_contact_select',
                array(
                    'required' => 'false',
                    'label' => 'stc.performance.contacts.label'
                )
            )
            ->add(
                'assignee',
                'oro_user_select',
                array(
                    'required' => false,
                    'label' => 'stc.performance.assignee.label'
                )
            )
            ->add(
                'bands',
                'collection',
                array(
                    'type' => 'text',
                    'options' => array(
                        'required' => true,
                        'attr' => array('class' => 'well'),
                        'allow_add' => true
                    )
                ))
            ->add(
                'profileType',
                'text',
                array(
                    'label' => 'stc.performance.profileType.label',
                    'required' => false,
                )
            )
            ->add(
                'performanceType',
                'text',
                array(
                    'label' => 'stc.performance.performanceType.label',
                    'required' => false,
                )
            )
            ->add(
                'status',
                'text',
                array(
                    'label' => 'stc.performance.staus.label',
                    'required' => false,
                )
            );
    }

    /**
     * @inheritdoc
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => $this->performanceClass
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'stc_performance';
    }
}