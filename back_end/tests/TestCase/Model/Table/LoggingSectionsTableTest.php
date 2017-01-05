<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoggingSectionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoggingSectionsTable Test Case
 */
class LoggingSectionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LoggingSectionsTable
     */
    public $LoggingSections;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.logging_sections'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LoggingSections') ? [] : ['className' => 'App\Model\Table\LoggingSectionsTable'];
        $this->LoggingSections = TableRegistry::get('LoggingSections', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LoggingSections);

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
