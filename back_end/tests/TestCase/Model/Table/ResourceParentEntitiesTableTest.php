<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResourceParentEntitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResourceParentEntitiesTable Test Case
 */
class ResourceParentEntitiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResourceParentEntitiesTable
     */
    public $ResourceParentEntities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('ResourceParentEntities') ? [] : ['className' => 'App\Model\Table\ResourceParentEntitiesTable'];
        $this->ResourceParentEntities = TableRegistry::get('ResourceParentEntities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResourceParentEntities);

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
