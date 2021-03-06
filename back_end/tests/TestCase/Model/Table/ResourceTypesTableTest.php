<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResourceTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResourceTypesTable Test Case
 */
class ResourceTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResourceTypesTable
     */
    public $ResourceTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.resource_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ResourceTypes') ? [] : ['className' => 'App\Model\Table\ResourceTypesTable'];
        $this->ResourceTypes = TableRegistry::get('ResourceTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResourceTypes);

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
