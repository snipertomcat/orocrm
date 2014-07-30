<?php

namespace Stc\Bundle\MapBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

use JMS\Serializer\Annotation as JMS;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\TagBundle\Entity\Taggable;
use Oro\Bundle\DataAuditBundle\Metadata\Annotation as Oro;

use Oro\Bundle\UserBundle\Entity\User;

use Stc\Bundle\MapBundle\Model\ExtendMap;
use Stc\Bundle\PerformanceBundle\Entity\Performance;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;
use Stc\Bundle\MapBundle\Entity\Coordinate;
/**
 * Map
 *
 * @ORM\Table(name="stc_maps", indexes={@ORM\Index(name="stc_maps_name_idx", columns={"name"})})
 * 
 * @Oro\Loggable
 * @ORM\Entity(repositoryClass="Stc\Bundle\MapBundle\Entity\Repository\MapRepository")
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
class Map extends ExtendMap implements Taggable
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
     * @ORM\Column(type="string", length=100, nullable=true, name="mapType")
     * @Oro\Versioned
     * @JMS\Type("string")
     * @ConfigField(
     * defaultValues={
     * "dataaudit"={"auditable"=true},
     * "email"={"available_in_template"=true}
     * }
     * )
     */
    protected $mapType;

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
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $owner;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     * @JMS\Type("boolean")
     */
    protected $deleted;

    /**
     * @ORM\OneToOne(targetEntity="Stc\Bundle\MapBundle\Entity\Coordinate")
     */
    protected $coordinate;

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
     * @return Map
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
     * Set deleted
     *
     * @param boolean $deleted
     * @return Map
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
    public function getMapType()
    {
        return $this->mapType;
    }

    /**
     * @param string $mapType
     */
    public function setMapType($mapType)
    {
        $this->mapType = $mapType;
    }

    /**
     * @param Coordinate $coordinate
     */
    public function setCoordinate(Coordinate $coordinate)
    {
        $this->coordinate = $coordinate;
    }

    /**
     * @return mixed
     */
    public function getCoordinate()
    {
        return $this->coordinate;
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
