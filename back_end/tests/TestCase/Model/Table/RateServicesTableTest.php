<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RateServicesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RateServicesTable Test Case
 */
class RateServicesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RateServicesTable
     */
    public $RateServices;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rate_services',
        'app.rates',
        'app.clients',
        'app.municipalities',
        'app.departments',
        'app.rates_clients',
        'app.client_contacts',
        'app.contact_types',
        'app.services'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RateServices') ? [] : ['className' => 'App\Model\Table\RateServicesTable'];
        $this->RateServices = TableRegistry::get('RateServices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RateServices);

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
