<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InputsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InputsTable Test Case
 */
class InputsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InputsTable
     */
    public $Inputs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.inputs',
        'app.products',
        'app.section',
        'app.studies',
        'app.specializations',
        'app.cost_centers',
        'app.format_types',
        'app.control_formats',
        'app.attentions',
        'app.appointments',
        'app.medical_offices',
        'app.centers',
        'app.studies_medical_offices',
        'app.appointment_dates',
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
        'app.user_centers',
        'app.appointment_states',
        'app.orders',
        'app.clients',
        'app.rates',
        'app.rates_clients',
        'app.external_specialists',
        'app.service_types',
        'app.order_states',
        'app.cie_ten_codes',
        'app.consultation_endings',
        'app.external_causes',
        'app.order_appointments',
        'app.bills',
        'app.bill_resolutions',
        'app.resolution_concepts',
        'app.bill_types',
        'app.payments',
        'app.form_payments',
        'app.results',
        'app.specialists',
        'app.studies_specialists',
        'app.schedule_specialists',
        'app.schedule_specialist_types',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.products_studies',
        'app.providers',
        'app.storage_ubications',
        'app.marks',
        'app.invima_codes',
        'app.units'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Inputs') ? [] : ['className' => 'App\Model\Table\InputsTable'];
        $this->Inputs = TableRegistry::get('Inputs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Inputs);

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
