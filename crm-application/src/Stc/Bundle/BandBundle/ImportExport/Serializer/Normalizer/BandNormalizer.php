<?php

namespace Stc\Bundle\BandBundle\ImportExport\Serializer\Normalizer;

use Doctrine\Common\Collections\Collection;

use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;

use Stc\Bundle\BandBundle\Model\ExtendBand;
use Stc\Bundle\BandBundle\Entity\BandStatus;
use Stc\Bundle\BandBundle\Entity\Band;

class BandNormalizer implements DenormalizerInterface, SerializerAwareInterface
{
    const BAND_TYPE         = 'Stc\Bundle\BandBundle\Entity\Band';
    const BAND_STATUS_TYPE  = 'Stc\Bundle\BandBundle\Entity\BandStatus';
    const USER_TYPE         = 'Oro\Bundle\UserBundle\Entity\User';
    const COLLECTION_TYPE   = 'Doctrine\Common\Collections\ArrayCollection';

    /*
    const EMAILS_TYPE       = 'ArrayCollection<OroCRM\Bundle\ContactBundle\Entity\ContactEmail>';
    const PHONES_TYPE       = 'ArrayCollection<OroCRM\Bundle\ContactBundle\Entity\ContactPhone>';
    const GROUPS_TYPE       = 'ArrayCollection<OroCRM\Bundle\ContactBundle\Entity\Group>';
    const ACCOUNTS_TYPE     = 'ArrayCollection<OroCRM\Bundle\AccountBundle\Entity\Account>';
    const ADDRESSES_TYPE    = 'ArrayCollection<OroCRM\Bundle\ContactBundle\Entity\ContactAddress>';
    */

    static protected $scalarFields = array(
        'id',
        'name',
        'createdAt',
        'updatedAt',
        'modifiedUserId',
        'owner_id',
        'description',
        'deleted',
        'assignee_id',
        'profileType',
        'industry',
        'annualRevenue',
        'phoneFax',
        'billingAddressStreet',
        'billingAddressCity',
        'billingAddressState',
        'billingAddressPostalcode',
        'country',
        'rating',
        'phoneOffice',
        'phoneAlternate',
        'website',
        'ownership',
        'employees',
        'tickerSymbol',
        'shippingAddressStreet',
        'shippingAddressCity',
        'shippingAddressState',
        'shippingAddressPostalcode',
        'shippingAddressCountry',
        'twitter',
        'facebook',
        'youtube',
        'vimeo',
        'myspace',
        'reverbnation',
        'linkdin',
        'googleplus',
        'tributeto',
        'genre',
        'acttype',
        'status_name',
        'jjwg_maps_lat_c',
        'jjwg_maps_lng_c'
    );

    static protected $objectFields = array(
        'contacts' => 'Collection',
        'owner' => 'User',
        'assignee' => 'User',
    );

     /**
     * @var SerializerInterface|NormalizerInterface|DenormalizerInterface
     */
    protected $serializer;

    public function setSerializer(SerializerInterface $serializer)
    {
        if (!$serializer instanceof NormalizerInterface || !$serializer instanceof DenormalizerInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'Serializer must implement "%s" and "%s"',
                    'Symfony\Component\Serializer\Normalizer\NormalizerInterface',
                    'Symfony\Component\Serializer\Normalizer\DenormalizerInterface'
                )
            );
        }
        $this->serializer = $serializer;
    }

    /**
     * @param Band $object
     * @param mixed $format
     * @param array $context
     * @return array
     * This is for exporting records & has been removed from class for now because importing records is the focus
     */
    public function normalize($object, $format = null, array $context = array())
    {
        /*$result = $this->getScalarFieldsValues($object);

        $result['source'] = $this->normalizeObject($object->getSource(), $format, $context);
        $result['method'] = $this->normalizeObject($object->getMethod(), $format, $context);
        $result['owner'] = $this->normalizeObject(
            $object->getOwner(),
            $format,
            array_merge($context, array('mode' => 'short'))
        );
        $result['assignedTo'] = $this->normalizeObject(
            $object->getAssignedTo(),
            $format,
            array_merge($context, array('mode' => 'short'))
        );
        $result['emails'] = $this->normalizeCollection($object->getEmails(), $format, $context);
        $result['phones'] = $this->normalizeCollection($object->getPhones(), $format, $context);
        $result['groups'] = $this->normalizeCollection($object->getGroups(), $format, $context);
        $result['accounts'] = $this->normalizeCollection(
            $object->getAccounts(),
            $format,
            array_merge($context, array('mode' => 'short'))
        );
        $result['addresses'] = $this->normalizeCollection(
            $object->getAddresses(),
            $format,
            $context
        );

        return $result;*/
    }

    /**
     * @param mixed $object
     * @param mixed $format
     * @param array $context
     * @return mixed
     */
    protected function normalizeObject($object, $format = null, array $context = array())
    {
        $result = null;
        if (is_object($object)) {
            $result = $this->serializer->normalize($object, $format, $context);
        }
        return $result;
    }

    /**
     * @param mixed $collection
     * @param mixed $format
     * @param array $context
     * @return mixed
     */
    protected function normalizeCollection($collection, $format = null, array $context = array())
    {
        $result = array();
        if ($collection instanceof Collection && !$collection->isEmpty()) {
            $result = $this->serializer->normalize($collection, $format, $context);
        }
        return $result;
    }

    /**
     * @param Band $object
     * @return array
     */
    protected function getScalarFieldsValues(Band $object)
    {
        $result = array();
        foreach (static::$scalarFields as $fieldName) {
            $getter = 'get' .ucfirst($fieldName);
            $result[$fieldName] = $object->$getter();
        }

        return $result;
    }

    /**
     * @param mixed $data
     * @param string $class
     * @param mixed $format
     * @param array $context
     * @return Band
     * This is for importing records
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $data = is_array($data) ? $data : array();
        $result = new Band();
        $this->setScalarFieldsValues($result, $data);
        $this->setObjectFieldsValues($result, $data);

        return $result;
    }

    /**
     * @param Band $object
     * @param array $data
     */
    protected function setScalarFieldsValues(Band $object, array $data)
    {
        foreach (static::$scalarFields as $fieldName) {
            $setter = 'set' .ucfirst($fieldName);
            if (array_key_exists($fieldName, $data)) {
                $object->$setter($data[$fieldName]);
            }
        }
    }

    /**
     * @param Band $object
     * @param array $data
     * @param mixed $format
     * @param array $context
     */
    protected function setObjectFieldsValues(Band $object, array $data, $format = null, array $context = array())
    {
        $this->setNotEmptyValues(
            $object,
            array(
                array(
                    'name' => 'owner',
                    'value' => $this->denormalizeObject(
                            $data,
                            'owner',
                            static::USER_TYPE,
                            $format,
                            array_merge($context, array('mode' => 'short'))
                        )
                ),
                array(
                    'name' => 'assignee',
                    'value' => $this->denormalizeObject(
                            $data,
                            'assignee',
                            static::USER_TYPE,
                            $format,
                            array_merge($context, array('mode' => 'short'))
                        )
                ),
                array(
                    'name' => 'contacts',
                    'value' => $this->denormalizeObject(
                            $data,
                            'contacts',
                            static::COLLECTION_TYPE,
                            $format,
                            $context
                        )
                ),
            )
        );
    }

    /**
     * @param Band $object
     * @param array $valuesData
     * Currently not needed - TO DELETE
     */
    protected function setNotEmptyValues(Band $object, array $valuesData)
    {
        foreach ($valuesData as $data) {
            $value = $data['value'];
            if (!$value) {
                continue;
            }
            if (isset($data['name'])) {
                $setter = 'set' . ucfirst($data['name']);
                $object->$setter($value);
            } elseif (isset($data['setter'])) {
                $setter = $data['setter'];
                $object->$setter($value);
            } elseif (is_array($value) || $value instanceof \Traversable) {
                $adder = $data['adder'];
                foreach ($value as $element) {
                    $object->$adder($element);
                }
            }
        }
    }

    /**
     * @param array $data
     * @param string $name
     * @param string $type
     * @param mixed $format
     * @param array $context
     * @return null|object
     */
    protected function denormalizeObject(array $data, $name, $type, $format = null, $context = array())
    {
        $result = null;
        if (!empty($data[$name])) {
            $result = $this->serializer->denormalize($data[$name], $type, $format, $context);

        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Band;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return is_array($data) && $type == static::BAND_TYPE;
    }
}
