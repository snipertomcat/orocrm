<?php

namespace Stc\Bundle\BandBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

use JMS\Serializer\Annotation as JMS;

use OroCRM\Bundle\ContactBundle\Entity\Contact;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

use Oro\Bundle\DataAuditBundle\Metadata\Annotation as Oro;

use Oro\Bundle\UserBundle\Entity\User;

use Stc\Bundle\BandBundle\Model\ExtendBand;
use Stc\Bundle\BandBundle\Entity\BandStatus;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;

/**
 * Band
 *
 * @ORM\Table(name="stc_bands", indexes={
 * @ORM\Index(name="stc_bands_name_idx", columns={"name"})
 * })
 * @ORM\HasLifecycleCallbacks()
 * @Oro\Loggable
 * @ORM\Entity(repositoryClass="Stc\Bundle\BandBundle\Entity\Repository\BandRepository")
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
class Band extends ExtendBand
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
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="youtube", type="string", length=255, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $youtube;

    /**
     * @var string
     *
     * @ORM\Column(name="vimeo", type="string", length=255, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $vimeo;

    /**
     * @var string
     *
     * @ORM\Column(name="myspace", type="string", length=255, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $myspace;

    /**
     * @var string
     *
     * @ORM\Column(name="reverbnation", type="string", length=255, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $reverbnation;

    /**
     * @var string
     *
     * @ORM\Column(name="linkdin", type="string", length=255, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $linkdin;

    /**
     * @var string
     *
     * @ORM\Column(name="googleplus", type="string", length=255, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $googleplus;

    /**
     * @var string
     *
     * @ORM\Column(name="tributeto", type="string", length=255)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $tributeto;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=255, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="acttype", type="string", length=15)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $actType;

    /**
     * @var Collection
     *
     * @ORM\ManyToOne(targetEntity="OroCRM\Bundle\ContactBundle\Entity\Contact")
     * @ORM\JoinColumn(name="contacts", referencedColumnName="id", onDelete="SET NULL")
     * @ORM\JoinTable(name="stc_band_contacts",
     * joinColumns={@ORM\JoinColumn(name="band_id", referencedColumnName="id", onDelete="CASCADE")},
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
     * Constructor
     */
    public function __construct()
    {
        //$this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Bands
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dateEntered
     *
     * @param \DateTime $dateEntered
     * @return Bands
     */
    public function setDateEntered($dateEntered)
    {
        $this->dateEntered = $dateEntered;

        return $this;
    }

    /**
     * Get dateEntered
     *
     * @return \DateTime
     */
    public function getDateEntered()
    {
        return $this->dateEntered;
    }

    /**
     * Set dateModified
     *
     * @param \DateTime $dateModified
     * @return Bands
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * Set modifiedUserId
     *
     * @param string $modifiedUserId
     * @return Bands
     */
    public function setModifiedUserId($modifiedUserId)
    {
        $this->modifiedUserId = $modifiedUserId;

        return $this;
    }

    /**
     * Get modifiedUserId
     *
     * @return string
     */
    public function getModifiedUserId()
    {
        return $this->modifiedUserId;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     * @return Bands
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Bands
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Bands
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

     /**
     * Get assigneeId
     *
     * @return string
     */
    public function getAssigneeId()
    {
        return $this->getAssignee() ? $this->getAssignee()->getId() : null;
    }

    /**
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @param User $assignee
     */
    public function setAssignee(User $assignee = null)
    {
        $this->assignee = $assignee;

        return $this;
    }


    /**
     * @param User $owner
     */
    public function setOwner(User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->getOwner() ? $this->getOwner()->getId() : null;
    }


    /**
     * Set profileType
     *
     * @param string $profileType
     * @return Bands
     */
    public function setProfileType($profileType)
    {
        $this->profileType = $profileType;

        return $this;
    }

    /**
     * Get profileType
     *
     * @return string
     */
    public function getProfileType()
    {
        return $this->profileType;
    }

    /**
     * Set industry
     *
     * @param string $industry
     * @return Bands
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;

        return $this;
    }

    /**
     * Get industry
     *
     * @return string
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * Set annualRevenue
     *
     * @param string $annualRevenue
     * @return Bands
     */
    public function setAnnualRevenue($annualRevenue)
    {
        $this->annualRevenue = $annualRevenue;

        return $this;
    }

    /**
     * Get annualRevenue
     *
     * @return string
     */
    public function getAnnualRevenue()
    {
        return $this->annualRevenue;
    }

    /**
     * Set phoneFax
     *
     * @param string $phoneFax
     * @return Bands
     */
    public function setPhoneFax($phoneFax)
    {
        $this->phoneFax = $phoneFax;

        return $this;
    }

    /**
     * Get phoneFax
     *
     * @return string
     */
    public function getPhoneFax()
    {
        return $this->phoneFax;
    }

    /**
     * Set billingAddressStreet
     *
     * @param string $billingAddressStreet
     * @return Bands
     */
    public function setBillingAddressStreet($billingAddressStreet)
    {
        $this->billingAddressStreet = $billingAddressStreet;

        return $this;
    }

    /**
     * Get billingAddressStreet
     *
     * @return string
     */
    public function getBillingAddressStreet()
    {
        return $this->billingAddressStreet;
    }

    /**
     * Set billingAddressCity
     *
     * @param string $billingAddressCity
     * @return Bands
     */
    public function setBillingAddressCity($billingAddressCity)
    {
        $this->billingAddressCity = $billingAddressCity;

        return $this;
    }

    /**
     * Get billingAddressCity
     *
     * @return string
     */
    public function getBillingAddressCity()
    {
        return $this->billingAddressCity;
    }

    /**
     * Set billingAddressState
     *
     * @param string $billingAddressState
     * @return Bands
     */
    public function setBillingAddressState($billingAddressState)
    {
        $this->billingAddressState = $billingAddressState;

        return $this;
    }

    /**
     * Get billingAddressState
     *
     * @return string
     */
    public function getBillingAddressState()
    {
        return $this->billingAddressState;
    }

    /**
     * Set billingAddressPostalcode
     *
     * @param string $billingAddressPostalcode
     * @return Bands
     */
    public function setBillingAddressPostalcode($billingAddressPostalcode)
    {
        $this->billingAddressPostalcode = $billingAddressPostalcode;

        return $this;
    }

    /**
     * Get billingAddressPostalcode
     *
     * @return string
     */
    public function getBillingAddressPostalcode()
    {
        return $this->billingAddressPostalcode;
    }

    /**
     * Set billingAddressCountry
     *
     * @param string $billingAddressCountry
     * @return Bands
     */
    public function setBillingAddressCountry($billingAddressCountry)
    {
        $this->billingAddressCountry = $billingAddressCountry;

        return $this;
    }

    /**
     * Get billingAddressCountry
     *
     * @return string
     */
    public function getBillingAddressCountry()
    {
        return $this->billingAddressCountry;
    }

    /**
     * Set rating
     *
     * @param string $rating
     * @return Bands
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set phoneOffice
     *
     * @param string $phoneOffice
     * @return Bands
     */
    public function setPhoneOffice($phoneOffice)
    {
        $this->phoneOffice = $phoneOffice;

        return $this;
    }

    /**
     * Get phoneOffice
     *
     * @return string
     */
    public function getPhoneOffice()
    {
        return $this->phoneOffice;
    }

    /**
     * Set phoneAlternate
     *
     * @param string $phoneAlternate
     * @return Bands
     */
    public function setPhoneAlternate($phoneAlternate)
    {
        $this->phoneAlternate = $phoneAlternate;

        return $this;
    }

    /**
     * Get phoneAlternate
     *
     * @return string
     */
    public function getPhoneAlternate()
    {
        return $this->phoneAlternate;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Bands
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set ownership
     *
     * @param string $ownership
     * @return Bands
     */
    public function setOwnership($ownership)
    {
        $this->ownership = $ownership;

        return $this;
    }

    /**
     * Get ownership
     *
     * @return string
     */
    public function getOwnership()
    {
        return $this->ownership;
    }

    /**
     * Set employees
     *
     * @param string $employees
     * @return Bands
     */
    public function setEmployees($employees)
    {
        $this->employees = $employees;

        return $this;
    }

    /**
     * Get employees
     *
     * @return string
     */
    public function getEmployees()
    {
        return $this->employees;
    }

    /**
     * Set tickerSymbol
     *
     * @param string $tickerSymbol
     * @return Bands
     */
    public function setTickerSymbol($tickerSymbol)
    {
        $this->tickerSymbol = $tickerSymbol;

        return $this;
    }

    /**
     * Get tickerSymbol
     *
     * @return string
     */
    public function getTickerSymbol()
    {
        return $this->tickerSymbol;
    }

    /**
     * Set shippingAddressStreet
     *
     * @param string $shippingAddressStreet
     * @return Bands
     */
    public function setShippingAddressStreet($shippingAddressStreet)
    {
        $this->shippingAddressStreet = $shippingAddressStreet;

        return $this;
    }

    /**
     * Get shippingAddressStreet
     *
     * @return string
     */
    public function getShippingAddressStreet()
    {
        return $this->shippingAddressStreet;
    }

    /**
     * Set shippingAddressCity
     *
     * @param string $shippingAddressCity
     * @return Bands
     */
    public function setShippingAddressCity($shippingAddressCity)
    {
        $this->shippingAddressCity = $shippingAddressCity;

        return $this;
    }

    /**
     * Get shippingAddressCity
     *
     * @return string
     */
    public function getShippingAddressCity()
    {
        return $this->shippingAddressCity;
    }

    /**
     * Set shippingAddressState
     *
     * @param string $shippingAddressState
     * @return Bands
     */
    public function setShippingAddressState($shippingAddressState)
    {
        $this->shippingAddressState = $shippingAddressState;

        return $this;
    }

    /**
     * Get shippingAddressState
     *
     * @return string
     */
    public function getShippingAddressState()
    {
        return $this->shippingAddressState;
    }

    /**
     * Set shippingAddressPostalcode
     *
     * @param string $shippingAddressPostalcode
     * @return Bands
     */
    public function setShippingAddressPostalcode($shippingAddressPostalcode)
    {
        $this->shippingAddressPostalcode = $shippingAddressPostalcode;

        return $this;
    }

    /**
     * Get shippingAddressPostalcode
     *
     * @return string
     */
    public function getShippingAddressPostalcode()
    {
        return $this->shippingAddressPostalcode;
    }

    /**
     * Set shippingAddressCountry
     *
     * @param string $shippingAddressCountry
     * @return Bands
     */
    public function setShippingAddressCountry($shippingAddressCountry)
    {
        $this->shippingAddressCountry = $shippingAddressCountry;

        return $this;
    }

    /**
     * Get shippingAddressCountry
     *
     * @return string
     */
    public function getShippingAddressCountry()
    {
        return $this->shippingAddressCountry;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     * @return Bands
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return Bands
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set youtube
     *
     * @param string $youtube
     * @return Bands
     */
    public function setYoutube($youtube)
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * Get youtube
     *
     * @return string
     */
    public function getYoutube()
    {
        return $this->youtube;
    }

    /**
     * Set vimeo
     *
     * @param string $vimeo
     * @return Bands
     */
    public function setVimeo($vimeo)
    {
        $this->vimeo = $vimeo;

        return $this;
    }

    /**
     * Get vimeo
     *
     * @return string
     */
    public function getVimeo()
    {
        return $this->vimeo;
    }

    /**
     * Set myspace
     *
     * @param string $myspace
     * @return Bands
     */
    public function setMyspace($myspace)
    {
        $this->myspace = $myspace;

        return $this;
    }

    /**
     * Get myspace
     *
     * @return string
     */
    public function getMyspace()
    {
        return $this->myspace;
    }

    /**
     * Set reverbnation
     *
     * @param string $reverbnation
     * @return Bands
     */
    public function setReverbnation($reverbnation)
    {
        $this->reverbnation = $reverbnation;

        return $this;
    }

    /**
     * Get reverbnation
     *
     * @return string
     */
    public function getReverbnation()
    {
        return $this->reverbnation;
    }

    /**
     * Set linkdin
     *
     * @param string $linkdin
     * @return Bands
     */
    public function setLinkdin($linkdin)
    {
        $this->linkdin = $linkdin;

        return $this;
    }

    /**
     * Get linkdin
     *
     * @return string
     */
    public function getLinkdin()
    {
        return $this->linkdin;
    }

    /**
     * Set googleplus
     *
     * @param string $googleplus
     * @return Bands
     */
    public function setGoogleplus($googleplus)
    {
        $this->googleplus = $googleplus;

        return $this;
    }

    /**
     * Get googleplus
     *
     * @return string
     */
    public function getGoogleplus()
    {
        return $this->googleplus;
    }

    /**
     * Set tributeto
     *
     * @param string $tributeto
     * @return Bands
     */
    public function setTributeto($tributeto)
    {
        $this->tributeto = $tributeto;

        return $this;
    }

    /**
     * Get tributeto
     *
     * @return string
     */
    public function getTributeto()
    {
        return $this->tributeto;
    }

    /**
     * Set genre
     *
     * @param string $genre
     * @return Bands
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set contactIdC
     *
     * @param string $contactIdC
     * @return Bands
     */
    public function setContactIdC($contactIdC)
    {
        $this->contactIdC = $contactIdC;

        return $this;
    }

    /**
     * Get contactIdC
     *
     * @return string
     */
    public function getContactIdC()
    {
        return $this->contactIdC;
    }

    /**
     * Set actType
     *
     * @param string $actType
     * @return Bands
     */
    public function setActType($actType)
    {
        $this->actType = $actType;

        return $this;
    }

    /**
     * Get actType
     *
     * @return string
     */
    public function getActType()
    {
        return $this->actType;
    }

    /**
     * Add contacts
     *
     * @param Contact $contacts
     * @return Bands
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

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAtValue($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAtValue($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @param string $jjwg_maps_lat_c
     */
    public function setJjwgMapsLatC($jjwg_maps_lat_c)
    {
        $this->jjwgMapsLatC = $jjwg_maps_lat_c;
    }

    /**
     * @return string
     */
    public function getJjwgMapsLatC()
    {
        return $this->jjwgMapsLatC;
    }

    /**
     * @param string $jjwg_maps_lng_c
     */
    public function setJjwgMapsLngC($jjwg_maps_lng_c)
    {
        $this->jjwgMapsLngC = $jjwg_maps_lng_c;
    }

    /**
     * @return string
     */
    public function getJjwgMapsLngC()
    {
        return $this->jjwgMapsLngC;
    }
}
