<?php

namespace Stc\Bundle\ContractBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

use JMS\Serializer\Annotation as JMS;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\TagBundle\Entity\Taggable;
use Oro\Bundle\DataAuditBundle\Metadata\Annotation as Oro;

use Oro\Bundle\UserBundle\Entity\User;

use Stc\Bundle\ContractBundle\Model\ExtendContract;
use Stc\Bundle\PerformanceBundle\Entity\Performance;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;

/**
 * Contract
 *
 * @ORM\Table(name="stc_contracts", indexes={@ORM\Index(name="stc_contracts_name_idx", columns={"name"})})
 * 
 * @Oro\Loggable
 * @ORM\Entity(repositoryClass="Stc\Bundle\ContractBundle\Entity\Repository\ContractRepository")
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
class Contract extends ExtendContract implements Taggable
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
     * @ORM\Column(type="string", length=255, nullable=true, name="name")
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
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="location")
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $location;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true, name="stage")
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $stage;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1, nullable=true, name="travel")
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $travel;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true, name="contractType")
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $contractType;

    /**
     * @var integer
     *
     * @ORM\Column(type="string", length=1, nullable=true, name="isSigned")
     * @Oro\Versioned
     * @JMS\Type("integer")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $isSigned;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $createdAt;

    /**
     * @var \DateTime $signed
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     * @ConfigField(
     * defaultValues={
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $signedAt;

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
     * @ORM\ManyToOne(targetEntity="Stc\Bundle\PerformanceBundle\Entity\Performance", inversedBy="contracts")
     */
    protected $performance;

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
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="updatedBy_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $updatedBy;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     * @JMS\Type("boolean")
     */
    protected $deleted;

    /**
     * Constructor
     */
    public function __construct()
    {

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
     * @return Contract
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
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Contract
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
     * @return \Oro\Bundle\UserBundle\Entity\User
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
     * @return \Oro\Bundle\UserBundle\Entity\User
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
     * @return int
     */
    public function getOwnerId()
    {
        return $this->getOwner() ? $this->getOwner()->getId() : null;
    }

    /**
     * @param \Oro\Bundle\UserBundle\Entity\User $updatedBy
     */
    public function setUpdatedBy(\Oro\Bundle\UserBundle\Entity\User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * @return \Oro\Bundle\UserBundle\Entity\User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @return int
     */
    public function getUpdatedById()
    {
        return $this->getUpdatedBy() ? $this->getUpdatedBy()->getId() : null;
    }


    /**
     * @return Performance
     */
    public function getPerformance()
    {
        return $this->performance;
    }

    /**
     * @param Performance $performance
     */
    public function setPerformance($performance)
    {
        //$this->performance = $performance;
        //$iterator = $this->performance->getIterator();
        //foreach ($iterator as $performance) {
        $this->performance = $performance;
        //}
    }

    public function addPerformance($performance)
    {
        if (!$this->performance->contains($performance)) {
            $this->performance->add($performance);
        }
    }

    public function removePerformance($performance)
    {
        if ($this->performance->contains($performance)) {
            $this->performance->removeElement($performance);
        }
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAtValue($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->setCreatedAtValue($createdAt);
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param $createdBy
     */
    public function setCreatedByValue($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @param $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->setCreatedByValue($createdBy);
    }

    /**
     * @return $this
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAtValue($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->setUpdatedAtValue($updatedAt);
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
     * @return string
     */
    public function getTravel()
    {
        return $this->travel;
    }

    /**
     * @param string $travel
     */
    public function setTravel($travel)
    {
        $this->travel = $travel;
    }

    /**
     * @return string
     */
    public function getContractType()
    {
        return $this->contractType;
    }

    /**
     * @param string $contractType
     */
    public function setContractType($contractType)
    {
        $this->contractType = $contractType;
    }

    /**
     * @return int
     */
    public function getIsSigned()
    {
        return $this->isSigned;
    }

    /**
     * @param int $isSigned
     */
    public function setIsSigned($isSigned)
    {
        $this->isSigned = $isSigned;
    }

    /**
     * @return \DateTime
     */
    public function getSignedAt()
    {
        return $this->signedAt;
    }

    /**
     * @param \DateTime $signedAt
     */
    public function setSignedAt($signedAt)
    {
        $this->signedAt = $signedAt;
    }

    /**
     * @return string
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * @param string $stage
     */
    public function setStage($stage)
    {
        $this->stage = $stage;
    }

    /**
     * Pre persist event handler
     *
     * 
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
     * 
     */
    public function preUpdate()
    {
        //$datetime = (new \DateTime)->createFromFormat('Y-m-d','now',new \DateTimeZone('America/Los_Angeles'));
        $datetime = new \DateTime('now');
        $datetime = $datetime->setTimezone(new \DateTimeZone('America/Los_Angeles'));
        $this->updatedAt = $datetime;
    }

}
