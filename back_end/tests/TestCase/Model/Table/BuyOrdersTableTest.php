<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BuyOrdersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BuyOrdersTable Test Case
 */
class BuyOrdersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BuyOrdersTable
     */
    public $BuyOrders;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.buy_orders',
        'app.users',
        'app.roles',
        'app.people',
        'app.document_types',
        'app.municipalities',
        'app.departments',
        'app.patients',
        'app.zones',
        'app.regimes',
        'app.eps',
        'app.centers',
        'app.user_centers',
        'app.providers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('BuyOrders') ? [] : ['className' => 'App\Model\Table\BuyOrdersTable'];
        $this->BuyOrders = TableRegistry::get('BuyOrders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BuyOrders);

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
