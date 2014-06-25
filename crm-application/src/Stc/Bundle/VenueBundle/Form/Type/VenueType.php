<?php

namespace Stc\Bundle\VenueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VenueType extends AbstractType
{
    /**
     * @var string
     */
    protected $venueClass;

    /**
     * @param string $venueClass
     */
    public function __construct($venueClass = 'Stc\Bundle\VenueBundle\Entity\Venue')
    {
        $this->venueClass = $venueClass;
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
                    'label' => 'stc.venue.name.label',
                    'required' => true,
                )
            )
            ->add(
                'description',
                'text',
                array(
                    'label' => 'stc.venue.description.label',
                    'required' => false,
                )
            )
            ->add(
                'contacts',
                'orocrm_contact_select',
                array(
                    'required' => 'false',
                    'label' => 'stc.venue.contacts.label'
                )
            )
            ->add(
                'assignee',
                'oro_user_select',
                array(
                    'required' => false,
                    'label' => 'stc.venue.assignee.label'
                )
            )
            ->add(
                'profileType',
                'text',
                array(
                    'label' => 'stc.venue.profileType.label',
                    'required' => false,
                )
            )
            ->add(
                'industry',
                'text',
                array(
                    'label' => 'stc.venue.industry.label',
                    'required' => false,
                )
            )
            ->add(
                'annualRevenue',
                'text',
                array(
                    'label' => 'stc.venue.annualRevenue.label',
                    'required' => false,
                )
            )
            ->add(
                'phoneFax',
                'text',
                array(
                    'label' => 'stc.venue.phoneFax.label',
                    'required' => false,
                )
            )
            ->add(
                'billingAddressStreet',
                'text',
                array(
                    'label' => 'stc.venue.billingAddressStreet.label',
                    'required' => true,
                )
            )
            ->add(
                'billingAddressCity',
                'text',
                array(
                    'label' => 'stc.venue.billingAddressCity.label',
                    'required' => false,
                )
            )
            ->add(
                'billingAddressState',
                'text',
                array(
                    'label' => 'stc.venue.billingAddressState.label',
                    'required' => false,
                )
            )
            ->add(
                'billingAddressPostalcode',
                'text',
                array(
                    'label' => 'stc.venue.billingAddressPostalcode.label',
                    'required' => false,
                )
            )
            ->add(
                'billingAddressCountry',
                'text',
                array(
                    'label' => 'stc.venue.country.label',
                    'required' => false,
                )
            )
            ->add(
                'rating',
                'text',
                array(
                    'label' => 'stc.venue.rating.label',
                    'required' => false,
                )
            )
            ->add(
                'phoneOffice',
                'text',
                array(
                    'label' => 'stc.venue.phoneOffice.label',
                    'required' => true,
                )
            )
            ->add(
                'phoneAlternate',
                'text',
                array(
                    'label' => 'stc.venue.phoneAlternate.label',
                    'required' => false,
                )
            )
            ->add(
                'website',
                'text',
                array(
                    'label' => 'stc.venue.website.label',
                    'required' => false,
                )
            )
            ->add(
                'ownership',
                'text',
                array(
                    'label' => 'stc.venue.ownership.label',
                    'required' => false,
                )
            )
            ->add(
                'employees',
                'text',
                array(
                    'label' => 'stc.venue.employees.label',
                    'required' => false,
                )
            )
            ->add(
                'tickerSymbol',
                'text',
                array(
                    'label' => 'stc.venue.tickerSymbol.label',
                    'required' => false,
                )
            )
            ->add(
                'shippingAddressStreet',
                'text',
                array(
                    'label' => 'stc.venue.shippingAddressStreet.label',
                    'required' => false,
                )
            )
            ->add(
                'shippingAddressCity',
                'text',
                array(
                    'label' => 'stc.venue.shippingAddressCity.label',
                    'required' => false,
                )
            )
            ->add(
                'shippingAddressState',
                'text',
                array(
                    'label' => 'stc.venue.shippingAddressState.label',
                    'required' => false,
                )
            )
            ->add(
                'shippingAddressPostalcode',
                'text',
                array(
                    'label' => 'stc.venue.shippingAddressPostalcode.label',
                    'required' => false,
                )
            )
            ->add(
                'shippingAddressCountry',
                'text',
                array(
                    'label' => 'stc.venue.shippingAddressCountry.label',
                    'required' => false,
                )
            )
            ->add(
                'venueType',
                'text',
                array(
                    'label' => 'stc.venue.venueType.label',
                    'required' => false,
                )
            )
            ->add(
                'capacity',
                'text',
                array(
                    'label' => 'stc.venue.capacity.label',
                    'required' => false,
                )
            )
            ->add(
                'ageLimit',
                'text',
                    array(
                    'label' => 'stc.venue.ageLimit.label',
                    'required' => false,
                )
            )
            ->add(
                'avgTicketPrice',
                'text',
                array(
                    'label' => 'stc.venue.avgTicketPrice.label',
                    'required' => false,
                )
            )
            ->add(
                'status',
                'text',
                array(
                    'label' => 'stc.venue.staus.label',
                    'required' => false,
                )
            )
            ->add(
                'twitter',
                'text',
                array(
                    'label' => 'stc.venue.twitter.label',
                    'required' => false,
                )
            )
            ->add(
                'facebook',
                'text',
                array(
                    'label' => 'stc.venue.facebook.label',
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
                'data_class' => $this->venueClass
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'stc_venue';
    }
}