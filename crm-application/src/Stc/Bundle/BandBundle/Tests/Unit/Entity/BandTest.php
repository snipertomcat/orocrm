<?php

namespace Stc\Bundle\BandBundle\Tests\Unit\Entity;

use Oro\Bundle\UserBundle\Entity\User;
use OroCRM\Bundle\ContactBundle\Entity\Contact;

use Stc\Bundle\BandBundle\Entity\Band;
use Stc\Bundle\BandBundle\Entity\BandStatus;

class BandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Band
     */
    protected $band;

    protected function setUp()
    {
        $this->band = new Band();
    }

    public function testId()
    {
        $this->assertNull($this->band->getId());
        $id = 100;
        $this->band->setId($id);
        $this->assertEquals($id, $this->band->getId());
    }

    public function testTitle()
    {
        $this->assertNull($this->band->getName());
        $text = 'test';
        $this->band->setName($text);
        $this->assertEquals($text, $this->band->getName());
    }

    public function testDescription()
    {
        $this->assertNull($this->band->getDescription());
        $text = 'test';
        $this->band->setDescription($text);
        $this->assertEquals($text, $this->band->getDescription());
    }

    public function testContacts()
    {
        $this->assertNull($this->band->getContacts());
        $this->assertNull($this->band->getContactIdC());
        $contact = new Contact();
        $contact->setId(100);
        $this->band->setContactIdC($contact);
        $this->assertEquals($contact, $this->band->getContacts());
        $this->assertEquals($contact->getId(), $this->band->getContactIdC());
    }

    public function testStatus()
    {
        $this->assertNull($this->band->getStatus());
        $status = new BandStatus('test');
        $this->band->setStatus($status);
        $this->assertEquals($status, $this->band->getStatus());
    }

    public function testAssignee()
    {
        $this->assertNull($this->band->getAssignee());
        $this->assertNull($this->band->getAssigneeId());
        $assignee = new User();
        $assignee->setId(100);
        $this->band->setAssignee($assignee);
        $this->assertEquals($assignee, $this->band->getAssignee());
        $this->assertEquals($assignee->getId(), $this->band->getAssigneeId());
    }

    public function testOwner()
    {
        $this->assertNull($this->band->getOwner());
        $this->assertNull($this->band->getOwnerId());
        $owner = new User();
        $owner->setId(100);
        $this->band->setOwner($owner);
        $this->assertEquals($owner, $this->band->getOwner());
        $this->assertEquals($owner->getId(), $this->band->getOwnerId());
    }

    public function testCreatedAt()
    {
        $this->assertNull($this->band->getCreatedAt());
        $createdAt = new \DateTime();
        $this->band->setCreatedAtValue($createdAt);
        $this->assertEquals($createdAt, $this->band->getCreatedAt());
    }

    public function testUpdatedAt()
    {
        $this->assertNull($this->band->getUpdatedAt());
        $updatedAt = new \DateTime();
        $this->band->setUpdatedAtValue($updatedAt);
        $this->assertEquals($updatedAt, $this->band->getUpdatedAt());
    }

    public function testPrePersist()
    {
        $this->band->prePersist();
        $this->assertInstanceOf('DateTime', $this->band->getCreatedAt());
    }

    public function testPreUpdate()
    {
        $this->band->preUpdate();
        $this->assertInstanceOf('DateTime', $this->band->getUpdatedAt());
    }
}