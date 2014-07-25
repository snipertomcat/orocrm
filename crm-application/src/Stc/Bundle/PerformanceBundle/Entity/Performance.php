<?php

namespace Stc\Bundle\PerformanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation as JMS;

use OroCRM\Bundle\ContactBundle\Entity\Contact;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\TagBundle\Entity\Taggable;
use Oro\Bundle\DataAuditBundle\Metadata\Annotation as Oro;

use Oro\Bundle\UserBundle\Entity\User as User;

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
class Performance extends ExtendPerformance implements Taggable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="name")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="text", nullable=true, name="description")
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\Column(type="string", length=50, nullable=true, name="profileType")
     */
    private $profileType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="website")
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=100, nullable=true, name="performanceType")
     */
    private $performanceType;

    /**
     * @ORM\Column(type="string", length=25, nullable=true, name="status")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=100, nullable=true, name="leadSource")
     */
    private $leadSource;

    /**
     * @ORM\Column(type="decimal", nullable=true, name="amount")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $closedAt;

    /**
     * @ORM\Column(type="string", length=100, nullable=true, name="nextStep")
     */
    private $nextStep;

    /**
     * @ORM\Column(type="string", length=100, nullable=true, name="salesStage")
     */
    private $salesStage;

    /**
     * @ORM\Column(type="float", length=100, nullable=true, name="probability")
     */
    private $probability;

    /**
     * @ORM\OneToOne(targetEntity="Stc\Bundle\VenueBundle\Entity\Venue", mappedBy="id")
     * @ORM\JoinColumn(name="venue_id", referencedColumnName="id")
     */
    private $venue;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $performanceDate;

    /**
     * @ORM\Column(type="string", length=100, nullable=true, name="performanceLength")
     */
    private $performanceLength;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $loadInAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $performanceEndAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $mealsIncluded;

    /**
     * @ORM\Column(type="decimal", nullable=true, name="performanceFee")
     */
    private $performanceFee;

    /**
     * @ORM\Column(type="decimal", nullable=true, name="budget")
     */
    private $budget;

    /**
     * @ORM\Column(type="decimal", nullable=true, name="flightBudget")
     */
    private $flightBudget;

    /**
     * @ORM\Column(type="decimal", nullable=true, name="rentalCarBudget")
     */
    private $rentalCarBudget;

    /**
     * @ORM\Column(type="decimal", nullable=true, name="hotelBudget")
     */
    private $hotelBudget;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $estimatedAttendance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $actualAttendance;

    /**
     * @ORM\Column(type="blob", nullable=true, name="postShowComments")
     */
    private $postShowComments;

    /**
     * @ORM\Column(type="text", nullable=true, name="travelComments")
     */
    private $travelComments;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $soundCheckAt;

    /**
     * @ORM\Column(type="string", length=100, nullable=true, name="performanceHostStatus")
     */
    private $performanceHostStatus;

    /**
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="assignee_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $assignee;

    /**
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $owner;

    /**
     * @ORM\ManyToMany(targetEntity="Stc\Bundle\BandBundle\Entity\Band")
     * @ORM\JoinTable(
     *     name="stc_performance_to_band",
     *     joinColumns={@ORM\JoinColumn(name="Performance_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="Band_id", referencedColumnName="id")}
     * )
     */
    private $bands;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->bands = new ArrayCollection();
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
        $iterator = $this->bands->getIterator();
        foreach ($iterator as $band) {
            $this->addBand($band);
        }
    }

    public function addBand($band)
    {
        if (!$this->bands->contains($band)) {
            $this->bands->add($band);
        }
    }

    public function removeBand($band)
    {
        if ($this->bands->contains($band)) {
            $this->bands->removeElement($band);
        }
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
        if (!$closedAt instanceof \DateTime) {
            $closedAt = new \DateTime($closedAt);
        } else {
            $closedAt = $closedAt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        }
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
        //$createdAtString = $createdAt->format('Y-m-d');
        //$datetime = $createdAt->createFromFormat('Y-m-d',$createdAtString,new \DateTimeZone('America/Los_Angeles'));
        $createdAt = $createdAt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
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
        if (!$loadInAt instanceof \DateTime) {
            $loadInAt = new \DateTime($loadInAt);
        } else {
            $loadInAt = $loadInAt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        }
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
        //$datetime = $performanceDate->createFromFormat('Y-m-d',$performanceDate->('string'),new \DateTimeZone('America/Los_Angeles'));
        if (null !== $performanceDate) {
            if (!$performanceDate instanceof \DateTime) {
                $performanceDate = new \DateTime($performanceDate);
            } else {
                $performanceDate = $performanceDate->setTimezone(new \DateTimeZone('America/Los_Angeles'));
            }
            $this->performanceDate = $performanceDate;
        } else {
            $this->performanceDate = new \DateTime('now');
        }
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
        if (!$performanceEndAt instanceof \DateTime) {
            $performanceEndAt = new \DateTime($performanceEndAt);
        } else {
            $performanceEndAt = $performanceEndAt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        }
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
    public function getSoundCheckAt()
    {
        return $this->soundCheckAt;
    }

    /**
     * @param \DateTime $soundCheckAt
     */
    public function setSoundCheckAt($soundCheckAt)
    {
        //$datetime = $soundCheckAt->createFromFormat('Y-m-d',$soundCheckAt->format('strintg'),new \DateTimeZone('America/Los_Angeles'));
        if (!$soundCheckAt instanceof \DateTime) {
            $soundCheckAt = new \DateTime($soundCheckAt);
        } else {
            $soundCheckAt = $soundCheckAt->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        }
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

    /*
     * @return ArrayCollection
     */
    public function getTags()
    {
        if (null === $this->tags) {
            $this->tags = new ArrayCollection();
        }

        return $this->tags;
    }

    /*
    * @param $tags
    * @return Performance
    */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return int
     */
    public function getTaggableId()
    {
        return $this->getId();
    }

    /**
     * Pre persist event handler
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        //$datetime = (new \DateTime)->createFromFormat('Y-m-d','now',new \DateTimeZone('America/Los_Angeles'));
        $datetime = new \DateTime('now');
        $datetime = $datetime->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        $this->createdAt = $datetime;
        $this->updatedAt = $datetime;
    }

    /**
     * Pre update event handler
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        //$datetime = (new \DateTime)->createFromFormat('Y-m-d','now',new \DateTimeZone('America/Los_Angeles'));
        $datetime = new \DateTime('now');
        $datetime = $datetime->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        $this->updatedAt = $datetime;
    }

}
