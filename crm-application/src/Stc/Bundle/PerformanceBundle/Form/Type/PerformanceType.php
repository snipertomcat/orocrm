<?php

namespace Stc\Bundle\PerformanceBundle\Form\Type;

use Stc\Bundle\VenueBundle\Entity\Venue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Oro\Bundle\FormBundle\Form\Type\CollectionType;

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
                'assignee',
                'oro_user_select',
                array(
                    'required' => false,
                    'label' => 'stc.performance.assignee.label'
                )
            )
            ->add(
                'leadSource',
                'text',
                array(
                    'label' => 'stc.performance.leadSource.label',
                    'required' => false
                )
            )
            ->add(
                'closedAt',
                'oro_datetime',
                array(
                    'label' => 'stc.performance.closedAt.label',
                    'required' => false
                )
            )
            ->add(
                'probability',
                'percent',
                [
                    'label' => 'stc.performance.probability.label',
                    'required' => false
                ]
            )
            ->add(
                'salesStage',
                'choice',
                [
                    'label' => 'stc.performance.salesStage.label',
                    'required' => true,
                    'choices' => [
                        'prospecting' => 'Prospecting',
                        'hot' => 'Hot',
                        'cold' => 'Cold',
                        'warm' => 'Warm',
                        'sold' => 'Sold'
                    ]
                ]
            )
            ->add(
                'nextStep',
                'text',
                [
                    'label' => 'stc.performance.nextStep.label',
                    'required' => false,
                ]
            )
            ->add(
                'venue',
                'entity',
                array(
                    'label'    => 'Venue',
                    'class'    => 'StcVenueBundle:Venue',
                    'property' => 'name',
                    'multiple' => false,
                    'expanded' => false,
                    'required' => true,
                )
            )
            ->add(
                'bands',
                'genemu_jqueryselect2_entity',
                array(
                    'class'                   => 'StcBandBundle:Band',
                    'required'                => true,
                    'multiple'                => true,
                    'label'                   => 'Bands',
                    'configs'                 => ['placeholder' => 'Please Select Bands'],
                    'property'                => 'name',
                    'by_reference'            => false
                )
            )
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
                'mealsIncluded',
                'choice',
                array(
                    'label' => 'stc.performance.mealsIncluded.label',
                    'required' => false,
                    'max_length' => 1,
                    'choices' => [
                        0 => 'No',
                        1 => 'Yes'
                    ]
                )
            )
            ->add(
                'amount',
                'money',
                [
                    'label' => 'stc.performance.amount.label',
                    'required' => false,
                    'currency' => 'USD'
                ]
            )
            ->add(
                'performanceFee',
                'money',
                [
                    'label' => 'stc.performance.performanceFee.label',
                    'required' => false,
                    'currency' => 'USD'
                ]
            )
            ->add(
                'budget',
                'money',
                [
                    'label' => 'stc.performance.budget.label',
                    'required' => false,
                    'currency' => 'USD'
                ]
            )
            ->add(
                'flightBudget',
                'money',
                [
                    'label' => 'stc.performance.flightBudget.label',
                    'required' => false,
                    'currency' => 'USD'
                ]
            )
            ->add(
                'rentalCarBudget',
                'money',
                [
                    'label' => 'stc.performance.rentalCarBudget.label',
                    'required' => false,
                    'currency' => 'USD'
                ]
            )
            ->add('hotelBudget',
                'money',
                [
                    'label' => 'stc.performance.hotelBudget.label',
                    'required' => false,
                    'currency' => 'USD'
                ]
            )
            ->add(
                'estimatedAttendance',
                'number',
                [
                    'label' => 'stc.performance.estimatedAttendance.label',
                    'required' => false
                ]
            )
            ->add(
                'actualAttendance',
                'number',
                [
                    'label' => 'stc.performance.actualAttendance.label',
                    'required' => false
                ]
            )
            ->add(
                'postShowComments',
                'textarea',
                [
                    'label' => 'stc.performance.postShowComments.label',
                    'required' => false
                ]
            )
            ->add(
                'travelComments',
                'textarea',
                [
                    'label' => 'stc.performance.travelComments.label',
                    'required' => false
                ]
            )
            ->add(
                'soundCheckAt',
                'oro_datetime',
                [
                    'label' => 'stc.performance.soundCheckAt.label',
                    'required' => false
                ]
            )
            ->add(
                'performanceEndAt',
                'oro_datetime',
                [
                    'label' => 'stc.performance.performanceEndAt.label',
                    'required' => false
                ]
            )
            ->add(
                'loadInAt',
                'oro_datetime',
                [
                    'label' => 'stc.performance.loadInAt.label',
                    'required' => false
                ]
            )
            ->add(
                'performanceDate',
                'oro_datetime',
                [
                    'label' => 'stc.performance.performanceDate.label',
                    'required' => true
                ]
            )
            ->add(
                'performanceLength',
                'number',
                [
                    'label' => 'stc.performance.performanceLength.label',
                    'required' => false
                ]
            )
            ->add(
                'performanceHostStatus',
                'text',
                [
                    'label' => 'stc.performance.performanceHostStatus.label',
                    'required' => false
                ]
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