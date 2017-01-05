<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductServicesTypesServicesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductServicesTypesServicesTable Test Case
 */
class ProductServicesTypesServicesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductServicesTypesServicesTable
     */
    public $ProductServicesTypesServices;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.product_services_types_services',
        'app.services',
        'app.product_services_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ProductServicesTypesServices') ? [] : ['className' => 'App\Model\Table\ProductServicesTypesServicesTable'];
        $this->ProductServicesTypesServices = TableRegistry::get('ProductServicesTypesServices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductServicesTypesServices);

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
