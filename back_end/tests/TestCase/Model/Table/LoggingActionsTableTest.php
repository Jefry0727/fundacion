<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoggingActionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoggingActionsTable Test Case
 */
class LoggingActionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LoggingActionsTable
     */
    public $LoggingActions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('LoggingActions') ? [] : ['className' => 'App\Model\Table\LoggingActionsTable'];
        $this->LoggingActions = TableRegistry::get('LoggingActions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LoggingActions);

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
}
