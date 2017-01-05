<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BiradsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BiradsTable Test Case
 */
class BiradsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BiradsTable
     */
    public $Birads;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.birads',
        'app.results'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Birads') ? [] : ['className' => 'App\Model\Table\BiradsTable'];
        $this->Birads = TableRegistry::get('Birads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Birads);

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
