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

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;

use Stc\Bundle\PerformanceBundle\Entity\Performance;
use Stc\Bundle\MapBundle\Model\ExtendCoordinate;

use Ivory\GoogleMapBundle\Entity\Coordinate as GMapsCoordinate;

/**
 * Coordinate
 *
 * @ORM\Table(name="stc_coordinate_cache", indexes={@ORM\Index(name="stc_maps_name_idx", columns={"name"})})
 *
 * @Oro\Loggable
 * @ORM\Entity(repositoryClass="Stc\Bundle\MapBundle\Entity\Repository\CoordinateRepository")
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
class Coordinate extends ExtendCoordinate implements Taggable
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
     * @var float
     *
     * @ORM\Column(type="float")
     * @JMS\Type("float")
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     * @JMS\Type("float")
     */
    private $longitude;

    public function __construct($lat = null, $lng = null)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLatitude($lat)
    {
        $this->latitude = $lat;
    }

    public function setLongitude($lng)
    {
        $this->longitude = $lng;
    }

    public function __toString()
    {
        return '(' . $this->latitude . ', ' . $this->longitude . ')';
    }

    public function createFromString($string)
    {
        if (strlen($string) < 1) {
            return new self;
        }
        $string = str_replace(['(', ')', ' '], '', $string);
        $data = explode(',', $string);
        if ($data[0] === "" || $data[1] === "") {
            return new self;
        }
        return new self($data[0], $data[1]);
    }

    public function toGmaps()
    {
        return new GMapsCoordinate($this->latitude, $this->longitude);
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

}