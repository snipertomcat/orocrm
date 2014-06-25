<?php

namespace Stc\Bundle\PerformanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation as JMS;

use OroCRM\Bundle\ContactBundle\Entity\Contact;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

use Oro\Bundle\DataAuditBundle\Metadata\Annotation as Oro;

use Oro\Bundle\UserBundle\Entity\User;

use Stc\Bundle\PerformanceBundle\Model\ExtendPerformance;
use Stc\Bundle\VenueBundle\Entity\Venue;
use Stc\Bundle\BandBundle\Entity\Band;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;


/**
 * Performance
 *
 * @ORM\Table(name="stc_performances", indexes={
 * @ORM\Index(name="stc_performances_name_idx", columns={"name"})
 * })
 * @ORM\HasLifecycleCallbacks()
 * @Oro\Loggable
 * @ORM\Entity(repositoryClass="Stc\Bundle\PerformanceBundle\Entity\Repository\PerformanceRepository")
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
class Performance extends ExtendPerformance
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
     * @ORM\Column(name="performanceType", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $performanceType;

    /**
     * Contacts storage
     *
     * @var Contact[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="OroCRM\Bundle\ContactBundle\Entity\Contact", mappedBy="id")
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
     * @ORM\Column(name="leadSource", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $leadSource;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="amountUsDollar", type="decimal", nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $amountUsDollar;

    /**
     * @var \DateTime $closed
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $closedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="nextStep", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $nextStep;

    /**
     * @var string
     *
     * @ORM\Column(name="salesStage", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $salesStage;

    /**
     * @var string
     *
     * @ORM\Column(name="probability", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $probability;

    /**
     * Bands storage
     *
     * @var Band[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Stc\Bundle\BandBundle\Entity\Band", mappedBy="name", cascade={"all"}, orphanRemoval=true)
     */
    protected $bands;

    /**
     * @var Venue
     *
     * @ORM\Column(type="integer", nullable=false)
     * @JMS\Type("integer")
     * @JMS\Accessor(getter="getVenueId")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $venue;

    /**
     * @var \DateTime $showDate
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $showDate;

    /**
     * @var \DateTime $performanceDate
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $performanceDate;

    /**
     * @var string
     *
     * @ORM\Column(name="performanceLength", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $performanceLength;

    /**
     * @var \DateTime $loadInAt
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $loadInAt;

    /**
     * @var \DateTime $perfomanceEndAt
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $performanceEndAt;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @JMS\Type("boolean")
     */
    protected $mealsIncluded;

    /**
     * @var string
     *
     * @ORM\Column(name="performanceFee", type="decimal", nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $performanceFee;

    /**
     * @var string
     *
     * @ORM\Column(name="budget", type="decimal", nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $budget;

    /**
     * @var string
     *
     * @ORM\Column(name="flightBudget", type="decimal", nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $flightBudget;

    /**
     * @var string
     *
     * @ORM\Column(name="rentalCarBudget", type="decimal", nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $rentalCarBudget;

    /**
     * @var string
     *
     * @ORM\Column(name="hotelBudget", type="decimal", nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $hotelBudget;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @JMS\Type("integer")
     */
    protected $estimatedAttendance;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $actualAttendance;

    /**
     * @var string
     *
     * @ORM\Column(name="postShowComments", type="text", nullable=true)
     * @Oro\Versioned
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )+
     * @JMS\Type("string")
     */
    protected $postShowComments;

    /**
     * @var string
     *
     * @ORM\Column(name="travelComments", type="text", nullable=true)
     * @Oro\Versioned
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )+
     * @JMS\Type("string")
     */
    protected $travelComments;

    /**
     * @var \DateTime $soundCheckAt
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $soundCheckAt;

    /**
     * @var string
     *
     * @ORM\Column(name="performanceHostStatus", type="string", length=100, nullable=true)
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $performanceHostStatus;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getActualAttendance()
    {
        return $this->actualAttendance;
    }

    /**
     * @param int $actualAttendance
     */
    public function setActualAttendance($actualAttendance)
    {
        $this->actualAttendance = $actualAttendance;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getAmountUsDollar()
    {
        return $this->amountUsDollar;
    }

    /**
     * @param string $amountUsDollar
     */
    public function setAmountUsDollar($amountUsDollar)
    {
        $this->amountUsDollar = $amountUsDollar;
    }

    /**
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @param \Oro\Bundle\UserBundle\Entity\User $assignee
     */
    public function setAssignee($assignee)
    {
        $this->assignee = $assignee;
    }


    /**
     * @return ArrayCollection
     */
    public function getBands()
    {
        return $this->bands;
    }

    /**
     * @param ArrayCollection $bands
     */
    public function setBands($bands)
    {
        $this->bands = $bands;
    }

    /**
     * @return string
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param string $budget
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
    }

    /**
     * @return \DateTime
     */
    public function getClosedAt()
    {
        return $this->closedAt;
    }

    /**
     * @param \DateTime $closedAt
     */
    public function setClosedAt($closedAt)
    {
        $this->closedAt = $closedAt;
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        $array = $this->contacts->toArray();
        if (!empty($array)) {
            return $array[0];
        }
    }

    /**
     * @param mixed $contacts
     */
    public function setContacts($contacts)
    {
        if (is_array($contacts)) {
            foreach ($contacts as $contact) {
                $this->addContact($contact);
            }
        } else {
            $this->addContact($contacts);
        }
    }

    /**
     * @return $this
     */
    public function addContact($contact)
    {
        $contactsToArray = $this->contacts->toArray();
        if (!in_array($contact, $contactsToArray)) {
            $this->contacts->add($contact);
        }
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getEstimatedAttendance()
    {
        return $this->estimatedAttendance;
    }

    /**
     * @param int $estimatedAttendance
     */
    public function setEstimatedAttendance($estimatedAttendance)
    {
        $this->estimatedAttendance = $estimatedAttendance;
    }

    /**
     * @return string
     */
    public function getFlightBudget()
    {
        return $this->flightBudget;
    }

    /**
     * @param string $flightBudget
     */
    public function setFlightBudget($flightBudget)
    {
        $this->flightBudget = $flightBudget;
    }

    /**
     * @return string
     */
    public function getHotelBudget()
    {
        return $this->hotelBudget;
    }

    /**
     * @param string $hotelBudget
     */
    public function setHotelBudget($hotelBudget)
    {
        $this->hotelBudget = $hotelBudget;
    }

    /**
     * @return int
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
     * @return string
     */
    public function getLeadSource()
    {
        return $this->leadSource;
    }

    /**
     * @param string $leadSource
     */
    public function setLeadSource($leadSource)
    {
        $this->leadSource = $leadSource;
    }

    /**
     * @return \DateTime
     */
    public function getLoadInAt()
    {
        return $this->loadInAt;
    }

    /**
     * @param \DateTime $loadInAt
     */
    public function setLoadInAt($loadInAt)
    {
        $this->loadInAt = $loadInAt;
    }

    /**
     * @return boolean
     */
    public function isMealsIncluded()
    {
        return $this->mealsIncluded;
    }

    /**
     * @param boolean $mealsIncluded
     */
    public function setMealsIncluded($mealsIncluded)
    {
        $this->mealsIncluded = $mealsIncluded;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getNextStep()
    {
        return $this->nextStep;
    }

    /**
     * @param string $nextStep
     */
    public function setNextStep($nextStep)
    {
        $this->nextStep = $nextStep;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param \Oro\Bundle\UserBundle\Entity\User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return \DateTime
     */
    public function getPerformanceDate()
    {
        return $this->performanceDate;
    }

    /**
     * @param \DateTime $performanceDate
     */
    public function setPerformanceDate($performanceDate)
    {
        $this->performanceDate = $performanceDate;
    }

    /**
     * @return \DateTime
     */
    public function getPerformanceEndAt()
    {
        return $this->performanceEndAt;
    }

    /**
     * @param \DateTime $performanceEndAt
     */
    public function setPerformanceEndAt($performanceEndAt)
    {
        $this->performanceEndAt = $performanceEndAt;
    }

    /**
     * @return string
     */
    public function getPerformanceFee()
    {
        return $this->performanceFee;
    }

    /**
     * @param string $performanceFee
     */
    public function setPerformanceFee($performanceFee)
    {
        $this->performanceFee = $performanceFee;
    }

    /**
     * @return string
     */
    public function getPerformanceHostStatus()
    {
        return $this->performanceHostStatus;
    }

    /**
     * @param string $performanceHostStatus
     */
    public function setPerformanceHostStatus($performanceHostStatus)
    {
        $this->performanceHostStatus = $performanceHostStatus;
    }

    /**
     * @return string
     */
    public function getPerformanceLength()
    {
        return $this->performanceLength;
    }

    /**
     * @param string $performanceLength
     */
    public function setPerformanceLength($performanceLength)
    {
        $this->performanceLength = $performanceLength;
    }

    /**
     * @return string
     */
    public function getPerformanceType()
    {
        return $this->performanceType;
    }

    /**
     * @param string $performanceType
     */
    public function setPerformanceType($performanceType)
    {
        $this->performanceType = $performanceType;
    }

    /**
     * @return string
     */
    public function getPostShowComments()
    {
        return $this->postShowComments;
    }

    /**
     * @param string $postShowComments
     */
    public function setPostShowComments($postShowComments)
    {
        $this->postShowComments = $postShowComments;
    }

    /**
     * @return string
     */
    public function getProbability()
    {
        return $this->probability;
    }

    /**
     * @param string $probability
     */
    public function setProbability($probability)
    {
        $this->probability = $probability;
    }

    /**
     * @return string
     */
    public function getProfileType()
    {
        return $this->profileType;
    }

    /**
     * @param string $profileType
     */
    public function setProfileType($profileType)
    {
        $this->profileType = $profileType;
    }

    /**
     * @return string
     */
    public function getRentalCarBudget()
    {
        return $this->rentalCarBudget;
    }

    /**
     * @param string $rentalCarBudget
     */
    public function setRentalCarBudget($rentalCarBudget)
    {
        $this->rentalCarBudget = $rentalCarBudget;
    }

    /**
     * @return string
     */
    public function getSalesStage()
    {
        return $this->salesStage;
    }

    /**
     * @param string $salesStage
     */
    public function setSalesStage($salesStage)
    {
        $this->salesStage = $salesStage;
    }

    /**
     * @return \DateTime
     */
    public function getShowDate()
    {
        return $this->showDate;
    }

    /**
     * @param \DateTime $showDate
     */
    public function setShowDate($showDate)
    {
        $this->showDate = $showDate;
    }

    /**
     * @return \DateTime
     */
    public function getSoundCheckAt()
    {
        return $this->soundCheckAt;
    }

    /**
     * @param \DateTime $soundCheckAt
     */
    public function setSoundCheckAt($soundCheckAt)
    {
        $this->soundCheckAt = $soundCheckAt;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getTravelComments()
    {
        return $this->travelComments;
    }

    /**
     * @param string $travelComments
     */
    public function setTravelComments($travelComments)
    {
        $this->travelComments = $travelComments;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return Venue
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * @param Venue $venue
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
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

    public function getVenueId()
    {
        return $this->getVenue()->getId();
    }

}
