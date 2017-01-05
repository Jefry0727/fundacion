<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResourceEntityDirectoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResourceEntityDirectoriesTable Test Case
 */
class ResourceEntityDirectoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResourceEntityDirectoriesTable
     */
    public $ResourceEntityDirectories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.resource_entity_directories',
        'app.resource_parent_entities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ResourceEntityDirectories') ? [] : ['className' => 'App\Model\Table\ResourceEntityDirectoriesTable'];
        $this->ResourceEntityDirectories = TableRegistry::get('ResourceEntityDirectories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResourceEntityDirectories);

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
