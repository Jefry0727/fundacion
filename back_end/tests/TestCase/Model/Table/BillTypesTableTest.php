<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BillTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BillTypesTable Test Case
 */
class BillTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BillTypesTable
     */
    public $BillTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bill_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('BillTypes') ? [] : ['className' => 'App\Model\Table\BillTypesTable'];
        $this->BillTypes = TableRegistry::get('BillTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BillTypes);

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
