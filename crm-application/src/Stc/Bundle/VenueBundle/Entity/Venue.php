<?php

namespace Stc\Bundle\VenueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

use JMS\Serializer\Annotation as JMS;

use OroCRM\Bundle\ContactBundle\Entity\Contact;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

use Oro\Bundle\DataAuditBundle\Metadata\Annotation as Oro;

use Oro\Bundle\UserBundle\Entity\User;

use Stc\Bundle\VenueBundle\Model\ExtendVenue;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;

/**
 * Venue
 *
 * @ORM\Table(name="stc_venues", indexes={
 * @ORM\Index(name="stc_venues_name_idx", columns={"name"})
 * })
 * @ORM\HasLifecycleCallbacks()
 * @Oro\Loggable
 * @ORM\Entity(repositoryClass="Stc\Bundle\VenueBundle\Entity\Repository\VenueRepository")
 * @Config(
 * defaultValues={
 * "ownership"={
 * "owner_type"="USER",
 * "owner_field_name"="owner",
 * "owner_column_name"="owner_id"
 * },
 * "security"={
 * "type"="ACL"
 * },
 * "dataaudit"={"auditable"=true}
 * }
 * )
 */
class Venue extends ExtendVenue
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Type("integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $name;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime")
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $createdAt;

    /**
     * @var \DateTime $updated
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $updatedAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="assignee_id", referencedColumnName="id", onDelete="SET NULL")
     * @Oro\Versioned("getUsername")
     * @JMS\Type("integer")
     * @JMS\Accessor(getter="getAssigneeId")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $assignee;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="SET NULL")
     * @Oro\Versioned("getUsername")
     * @JMS\Type("integer")
     * @JMS\Accessor(getter="getOwnerId")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Oro\Versioned
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )+
     * @JMS\Type("string")
     */
    protected $description;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @JMS\Type("boolean")
     */
    protected $deleted;

    /**
     * @var string
     *
     * @ORM\Column(name="profileType", type="string", length=50, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $profileType;

    /**
     * @var string
     *
     * @ORM\Column(name="industry", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $industry;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer",nullable=true)
     * @JMS\Type("integer")
     */
    protected $annualRevenue;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneFax", type="string", length=15, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $phoneFax;

    /**
     * @var string
     *
     * @ORM\Column(name="billingAddressStreet", type="string", length=255)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $billingAddressStreet;

    /**
     * @var string
     *
     * @ORM\Column(name="billingAddressCity", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $billingAddressCity;

    /**
     * @var string
     *
     * @ORM\Column(name="billingAddressState", type="string", length=25, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $billingAddressState;

    /**
     * @var string
     *
     * @ORM\Column(name="billingAddressPostalcode", type="string", length=10, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $billingAddressPostalcode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $billingAddressCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="rating", type="string", length=50, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $rating;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneOffice", type="string", length=15)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $phoneOffice;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneAlternate", type="string", length=15, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $phoneAlternate;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $website;

    /**
     * @var string
     *
     * @ORM\Column(name="ownership", type="string", length=25, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $ownership;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     * @JMS\Type("integer")
     */
    protected $employees;

    /**
     * @var string
     *
     * @ORM\Column(name="tickerSymbol", type="string", length=25, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $tickerSymbol;

    /**
     * @var string
     *
     * @ORM\Column(name="shippingAddressStreet", type="string", length=255, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $shippingAddressStreet;

    /**
     * @var string
     *
     * @ORM\Column(name="shippingAddressCity", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $shippingAddressCity;

    /**
     * @var string
     *
     * @ORM\Column(name="shippingAddressState", type="string", length=25, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $shippingAddressState;

    /**
     * @var string
     *
     * @ORM\Column(name="shippingAddressPostalcode", type="string", length=10, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $shippingAddressPostalcode;

    /**
     * @var string
     *
     * @ORM\Column(name="shippingAddressCountry", type="string", length=50, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $shippingAddressCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="venueType", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $venueType;

    /**
     * @var string
     *
     * @ORM\Column(name="capacity", type="integer", nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $capacity;

    /**
     * @var string
     *
     * @ORM\Column(name="ageLimit", type="string", length=25, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $ageLimit;

    /**
     * @var string
     *
     * @ORM\Column(name="avgTicketPrice", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $avgTicketPrice;


    /**
     * @var Collection
     *
     * @ORM\ManyToOne(targetEntity="OroCRM\Bundle\ContactBundle\Entity\Contact")
     * @ORM\JoinColumn(name="contacts", referencedColumnName="id", onDelete="SET NULL")
     * @ORM\JoinTable(name="stc_venue_contacts",
     * joinColumns={@ORM\JoinColumn(name="venue_id", referencedColumnName="id", onDelete="CASCADE")},
     * inverseJoinColumns={@ORM\JoinColumn(name="contact_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     * @Oro\Versioned
     * @JMS\Type("integer")
     * @JMS\Accessor(getter="getRelatedContactId")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $contacts;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=25)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=25, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=25, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="jjwgMapsLatC", type="string", length=50, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $jjwgMapsLatC;

    /**
     * @var string
     *
     * @ORM\Column(name="jjwgMapsLngC", type="string", length=50, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $jjwgMapsLngC;

    /**
     * @var string
     *
     * @ORM\Column(name="gguid", type="string", length=50, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $gguid;

    /**
     * Constructor
     */
    public function __construct()
    {
        //$this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /* GETTERS */

    /**
     * @return string
     */
    public function getAgeLimit()
    {
        return $this->ageLimit;
    }

    /**
     * @return int
     */
    public function getAnnualRevenue()
    {
        return $this->annualRevenue;
    }

    /**
     * @return \Oro\Bundle\UserBundle\Entity\User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @return string
     */
    public function getAvgTicketPrice()
    {
        return $this->avgTicketPrice;
    }

    /**
     * @return string
     */
    public function getBillingAddressCity()
    {
        return $this->billingAddressCity;
    }

    /**
     * @return string
     */
    public function getBillingAddressCountry()
    {
        return $this->billingAddressCountry;
    }

    /**
     * @return string
     */
    public function getBillingAddressPostalcode()
    {
        return $this->billingAddressPostalcode;
    }

    /**
     * @return string
     */
    public function getBillingAddressState()
    {
        return $this->billingAddressState;
    }

    /**
     * @return string
     */
    public function getBillingAddressStreet()
    {
        return $this->billingAddressStreet;
    }

    /**
     * @return string
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getEmployees()
    {
        return $this->employees;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * @return string
     */
    public function getJjwgMapsLatC()
    {
        return $this->jjwgMapsLatC;
    }

    /**
     * @return string
     */
    public function getJjwgMapsLngC()
    {
        return $this->jjwgMapsLngC;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \Oro\Bundle\UserBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return string
     */
    public function getOwnership()
    {
        return $this->ownership;
    }

    /**
     * @return string
     */
    public function getPhoneAlternate()
    {
        return $this->phoneAlternate;
    }

    /**
     * @return string
     */
    public function getPhoneFax()
    {
        return $this->phoneFax;
    }

    /**
     * @return string
     */
    public function getPhoneOffice()
    {
        return $this->phoneOffice;
    }

    /**
     * @return string
     */
    public function getProfileType()
    {
        return $this->profileType;
    }

    /**
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @return string
     */
    public function getShippingAddressCity()
    {
        return $this->shippingAddressCity;
    }

    /**
     * @return string
     */
    public function getShippingAddressCountry()
    {
        return $this->shippingAddressCountry;
    }

    /**
     * @return string
     */
    public function getShippingAddressPostalcode()
    {
        return $this->shippingAddressPostalcode;
    }

    /**
     * @return string
     */
    public function getShippingAddressState()
    {
        return $this->shippingAddressState;
    }

    /**
     * @return string
     */
    public function getShippingAddressStreet()
    {
        return $this->shippingAddressStreet;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getTickerSymbol()
    {
        return $this->tickerSymbol;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getVenueType()
    {
        return $this->venueType;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }


    /**
     * Add contacts
     *
     * @param Contact $contacts
     * @return Venue
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param Contact $contacts
     */
    public function removeContact(Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }


    /* SETTERS */

    /**
     * @param string $ageLimit
     */
    public function setAgeLimit($ageLimit)
    {
        $this->ageLimit = $ageLimit;
    }

    /**
     * @param int $annualRevenue
     */
    public function setAnnualRevenue($annualRevenue)
    {
        $this->annualRevenue = $annualRevenue;
    }

    /**
     * @param \Oro\Bundle\UserBundle\Entity\User $assignee
     */
    public function setAssignee($assignee)
    {
        $this->assignee = $assignee;
    }

    /**
     * @param string $avgTicketPrice
     */
    public function setAvgTicketPrice($avgTicketPrice)
    {
        $this->avgTicketPrice = $avgTicketPrice;
    }

    /**
     * @param string $billingAddressCity
     */
    public function setBillingAddressCity($billingAddressCity)
    {
        $this->billingAddressCity = $billingAddressCity;
    }

    /**
     * @param string $billingAddressCountry
     */
    public function setBillingAddressCountry($billingAddressCountry)
    {
        $this->billingAddressCountry = $billingAddressCountry;
    }

    /**
     * @param string $billingAddressPostalcode
     */
    public function setBillingAddressPostalcode($billingAddressPostalcode)
    {
        $this->billingAddressPostalcode = $billingAddressPostalcode;
    }

    /**
     * @param string $billingAddressState
     */
    public function setBillingAddressState($billingAddressState)
    {
        $this->billingAddressState = $billingAddressState;
    }

    /**
     * @param string $billingAddressStreet
     */
    public function setBillingAddressStreet($billingAddressStreet)
    {
        $this->billingAddressStreet = $billingAddressStreet;
    }

    /**
     * @param string $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param int $employees
     */
    public function setEmployees($employees)
    {
        $this->employees = $employees;
    }

    /**
     * @param string $industry
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;
    }

    /**
     * @param string $jjwgMapsLatC
     */
    public function setJjwgMapsLatC($jjwgMapsLatC)
    {
        $this->jjwgMapsLatC = $jjwgMapsLatC;
    }

    /**
     * @param string $jjwgMapsLngC
     */
    public function setJjwgMapsLngC($jjwgMapsLngC)
    {
        $this->jjwgMapsLngC = $jjwgMapsLngC;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param \Oro\Bundle\UserBundle\Entity\User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @param string $ownership
     */
    public function setOwnership($ownership)
    {
        $this->ownership = $ownership;
    }

    /**
     * @param string $phoneAlternate
     */
    public function setPhoneAlternate($phoneAlternate)
    {
        $this->phoneAlternate = $phoneAlternate;
    }

    /**
     * @param string $phoneFax
     */
    public function setPhoneFax($phoneFax)
    {
        $this->phoneFax = $phoneFax;
    }

    /**
     * @param string $phoneOffice
     */
    public function setPhoneOffice($phoneOffice)
    {
        $this->phoneOffice = $phoneOffice;
    }

    /**
     * @param string $profileType
     */
    public function setProfileType($profileType)
    {
        $this->profileType = $profileType;
    }

    /**
     * @param string $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @param string $shippingAddressCity
     */
    public function setShippingAddressCity($shippingAddressCity)
    {
        $this->shippingAddressCity = $shippingAddressCity;
    }

    /**
     * @param string $shippingAddressCountry
     */
    public function setShippingAddressCountry($shippingAddressCountry)
    {
        $this->shippingAddressCountry = $shippingAddressCountry;
    }

    /**
     * @param string $shippingAddressPostalcode
     */
    public function setShippingAddressPostalcode($shippingAddressPostalcode)
    {
        $this->shippingAddressPostalcode = $shippingAddressPostalcode;
    }

    /**
     * @param string $shippingAddressState
     */
    public function setShippingAddressState($shippingAddressState)
    {
        $this->shippingAddressState = $shippingAddressState;
    }

    /**
     * @param string $shippingAddressStreet
     */
    public function setShippingAddressStreet($shippingAddressStreet)
    {
        $this->shippingAddressStreet = $shippingAddressStreet;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param string $tickerSymbol
     */
    public function setTickerSymbol($tickerSymbol)
    {
        $this->tickerSymbol = $tickerSymbol;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param string $venueType
     */
    public function setVenueType($venueType)
    {
        $this->venueType = $venueType;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @param string $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param string $gguid
     */
    public function setGguid($gguid)
    {
        $this->gguid = $gguid;
    }

    /**
     * @return string
     */
    public function getGguid()
    {
        return $this->gguid;
    }

    /**
     * @param string $twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @return string
     */
    public function getAssigneeId()
    {
        $assignee = $this->getAssignee();

        if (is_object($assignee)) {
            return $assignee->getId();
        }
    }

    /**
     * @return string
     */
    public function getOwnerId()
    {
        $owner = $this->getOwner();

        if (is_object($owner)) {
            return $owner->getId();
        }
    }

    /**
     * @return collection
     */
    public function getRelatedContactId()
    {
        if ($related = $this->getContacts()) {
            if (!empty($related->toArray())) {
                $ids = array();
                foreach ($related as $record) {
                    $ids[] = $related->getId();
                }
            }
        }
    }

}
