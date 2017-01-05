<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResourceExtensionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResourceExtensionsTable Test Case
 */
class ResourceExtensionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResourceExtensionsTable
     */
    public $ResourceExtensions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.resource_extensions',
        'app.resource_file_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ResourceExtensions') ? [] : ['className' => 'App\Model\Table\ResourceExtensionsTable'];
        $this->ResourceExtensions = TableRegistry::get('ResourceExtensions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResourceExtensions);

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
