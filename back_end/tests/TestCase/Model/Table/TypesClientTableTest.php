<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TypesClientTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TypesClientTable Test Case
 */
class TypesClientTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TypesClientTable
     */
    public $TypesClient;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.types_client',
        'app.clients',
        'app.municipalities',
        'app.departments',
        'app.rates',
        'app.rates_clients',
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
        $config = TableRegistry::exists('TypesClient') ? [] : ['className' => 'App\Model\Table\TypesClientTable'];
        $this->TypesClient = TableRegistry::get('TypesClient', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TypesClient);

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
