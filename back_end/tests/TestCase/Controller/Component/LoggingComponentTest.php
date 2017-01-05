<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\LoggingComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\LoggingComponent Test Case
 */
class LoggingComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\LoggingComponent
     */
    public $Logging;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Logging = new LoggingComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Logging);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
