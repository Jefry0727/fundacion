<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AppointmentsSuppliesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AppointmentsSuppliesTable Test Case
 */
class AppointmentsSuppliesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AppointmentsSuppliesTable
     */
    public $AppointmentsSupplies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.appointments_supplies',
        'app.appointments',
        'app.medical_offices',
        'app.studies',
        'app.specializations',
        'app.service_types',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.studies_medical_offices',
        'app.specialists',
        'app.people',
        'app.document_types',
        'app.patients',
        'app.users',
        'app.roles',
        'app.zones',
        'app.regimes',
        'app.studies_specialists',
        'app.schedule_specialists',
        'app.schedule_specialist_types',
        'app.products',
        'app.products_studies',
        'app.appointment_dates',
        'app.appointment_states',
        'app.attentions',
        'app.results',
        'app.orders',
        'app.clients',
        'app.municipalities',
        'app.departments',
        'app.rates',
        'app.rates_clients',
        'app.external_specialists',
        'app.order_types',
        'app.centers',
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
        'app.form_payments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AppointmentsSupplies') ? [] : ['className' => 'App\Model\Table\AppointmentsSuppliesTable'];
        $this->AppointmentsSupplies = TableRegistry::get('AppointmentsSupplies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AppointmentsSupplies);

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
