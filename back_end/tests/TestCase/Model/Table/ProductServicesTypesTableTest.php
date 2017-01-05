<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductServicesTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductServicesTypesTable Test Case
 */
class ProductServicesTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductServicesTypesTable
     */
    public $ProductServicesTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.product_services_types',
        'app.services',
        'app.product_services_types_services'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ProductServicesTypes') ? [] : ['className' => 'App\Model\Table\ProductServicesTypesTable'];
        $this->ProductServicesTypes = TableRegistry::get('ProductServicesTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductServicesTypes);

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
