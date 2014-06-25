<?php

namespace Stc\Bundle\BandBundle\Tests\Unit\Entity;

use Stc\Bundle\BandBundle\Entity\BandStatus;

class BandStatusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BandStatus
     */
    protected $bandStatus;

    /**
     * @var string
     */
    protected $testName = 'test';

    protected function setUp()
    {
        $this->bandStatus = new BandStatus($this->testName);
    }

    public function testName()
    {
        $this->assertEquals($this->testName, $this->bandStatus->getName());
    }

    public function testLabel()
    {
        $this->assertNull($this->bandStatus->getLabel());
        $label = 'test';
        $this->taskStatus->setLabel($label);
        $this->assertEquals($label, $this->bandStatus->getLabel());
    }
}