<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClientBusinessTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClientBusinessTable Test Case
 */
class ClientBusinessTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ClientBusinessTable
     */
    public $ClientBusiness;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.client_business',
        'app.clients',
        'app.municipalities',
        'app.departments',
        'app.rates',
        'app.rates_clients',
        'app.business_terms'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ClientBusiness') ? [] : ['className' => 'App\Model\Table\ClientBusinessTable'];
        $this->ClientBusiness = TableRegistry::get('ClientBusiness', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClientBusiness);

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
