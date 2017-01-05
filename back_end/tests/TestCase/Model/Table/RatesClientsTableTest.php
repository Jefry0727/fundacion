<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RatesClientsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RatesClientsTable Test Case
 */
class RatesClientsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RatesClientsTable
     */
    public $RatesClients;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rates_clients',
        'app.rates',
        'app.clients',
        'app.municipalities',
        'app.departments',
        'app.client_contacts',
        'app.contact_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RatesClients') ? [] : ['className' => 'App\Model\Table\RatesClientsTable'];
        $this->RatesClients = TableRegistry::get('RatesClients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RatesClients);

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
