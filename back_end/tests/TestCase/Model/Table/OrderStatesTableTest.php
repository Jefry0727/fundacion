<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderStatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderStatesTable Test Case
 */
class OrderStatesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderStatesTable
     */
    public $OrderStates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.order_states'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('OrderStates') ? [] : ['className' => 'App\Model\Table\OrderStatesTable'];
        $this->OrderStates = TableRegistry::get('OrderStates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrderStates);

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
