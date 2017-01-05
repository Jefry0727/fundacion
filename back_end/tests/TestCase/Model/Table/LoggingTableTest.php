<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoggingTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoggingTable Test Case
 */
class LoggingTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LoggingTable
     */
    public $Logging;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.logging',
        'app.users',
        'app.roles',
        'app.people',
        'app.logging_sections',
        'app.logging_actions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Logging') ? [] : ['className' => 'App\Model\Table\LoggingTable'];
        $this->Logging = TableRegistry::get('Logging', $config);
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
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
