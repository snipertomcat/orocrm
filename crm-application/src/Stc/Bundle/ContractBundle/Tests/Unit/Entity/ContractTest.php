<?php

namespace Stc\Bundle\ContractBundle\Tests\Unit\Entity;

use Oro\Bundle\UserBundle\Entity\User;
use OroCRM\Bundle\ContactBundle\Entity\Contact;

use Stc\Bundle\ContractBundle\Entity\Contract;
use Stc\Bundle\ContractBundle\Entity\ContractStatus;

class ContractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Contract
     */
    protected $contract;

    protected function setUp()
    {
        $this->contract = new Contract();
    }

    public function testId()
    {
        $this->assertNull($this->contract->getId());
        $id = 100;
        $this->contract->setId($id);
        $this->assertEquals($id, $this->contract->getId());
    }

    public function testTitle()
    {
        $this->assertNull($this->contract->getName());
        $text = 'test';
        $this->contract->setName($text);
        $this->assertEquals($text, $this->contract->getName());
    }

    public function testDescription()
    {
        $this->assertNull($this->contract->getDescription());
        $text = 'test';
        $this->contract->setDescription($text);
        $this->assertEquals($text, $this->contract->getDescription());
    }

    public function testContacts()
    {
        $this->assertNull($this->contract->getContacts());
        $this->assertNull($this->contract->getContactIdC());
        $contact = new Contact();
        $contact->setId(100);
        $this->contract->setContactIdC($contact);
        $this->assertEquals($contact, $this->contract->getContacts());
        $this->assertEquals($contact->getId(), $this->contract->getContactIdC());
    }

    public function testStatus()
    {
        $this->assertNull($this->contract->getStatus());
        $status = new ContractStatus('test');
        $this->contract->setStatus($status);
        $this->assertEquals($status, $this->contract->getStatus());
    }

    public function testAssignee()
    {
        $this->assertNull($this->contract->getAssignee());
        $this->assertNull($this->contract->getAssigneeId());
        $assignee = new User();
        $assignee->setId(100);
        $this->contract->setAssignee($assignee);
        $this->assertEquals($assignee, $this->contract->getAssignee());
        $this->assertEquals($assignee->getId(), $this->contract->getAssigneeId());
    }

    public function testOwner()
    {
        $this->assertNull($this->contract->getOwner());
        $this->assertNull($this->contract->getOwnerId());
        $owner = new User();
        $owner->setId(100);
        $this->contract->setOwner($owner);
        $this->assertEquals($owner, $this->contract->getOwner());
        $this->assertEquals($owner->getId(), $this->contract->getOwnerId());
    }

    public function testCreatedAt()
    {
        $this->assertNull($this->contract->getCreatedAt());
        $createdAt = new \DateTime();
        $this->contract->setCreatedAtValue($createdAt);
        $this->assertEquals($createdAt, $this->contract->getCreatedAt());
    }

    public function testUpdatedAt()
    {
        $this->assertNull($this->contract->getUpdatedAt());
        $updatedAt = new \DateTime();
        $this->contract->setUpdatedAtValue($updatedAt);
        $this->assertEquals($updatedAt, $this->contract->getUpdatedAt());
    }

    public function testPrePersist()
    {
        $this->contract->prePersist();
        $this->assertInstanceOf('DateTime', $this->contract->getCreatedAt());
    }

    public function testPreUpdate()
    {
        $this->contract->preUpdate();
        $this->assertInstanceOf('DateTime', $this->contract->getUpdatedAt());
    }
}