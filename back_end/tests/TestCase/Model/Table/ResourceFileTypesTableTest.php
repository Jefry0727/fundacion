<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResourceFileTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResourceFileTypesTable Test Case
 */
class ResourceFileTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResourceFileTypesTable
     */
    public $ResourceFileTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('ResourceFileTypes') ? [] : ['className' => 'App\Model\Table\ResourceFileTypesTable'];
        $this->ResourceFileTypes = TableRegistry::get('ResourceFileTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResourceFileTypes);

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
