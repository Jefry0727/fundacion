<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RipMedicamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RipMedicamentosTable Test Case
 */
class RipMedicamentosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RipMedicamentosTable
     */
    public $RipMedicamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rip_medicamentos',
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
        $config = TableRegistry::exists('RipMedicamentos') ? [] : ['className' => 'App\Model\Table\RipMedicamentosTable'];
        $this->RipMedicamentos = TableRegistry::get('RipMedicamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RipMedicamentos);

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
