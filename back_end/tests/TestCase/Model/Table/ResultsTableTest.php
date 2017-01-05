<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResultsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResultsTable Test Case
 */
class ResultsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResultsTable
     */
    public $Results;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.results',
        'app.attentions',
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
        'app.appointments',
        'app.medical_offices',
        'app.studies',
        'app.specializations',
        'app.cost_centers',
        'app.business_units',
        'app.format_types',
        'app.control_formats',
        'app.specialists',
        'app.studies_specialists',
        'app.schedule_specialists',
        'app.schedule_specialist_types',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.studies_medical_offices',
        'app.service_types',
        'app.services',
        'app.products_studies',
        'app.instructives',
        'app.instructive_studies',
        'app.appointment_dates',
        'app.appointment_states',
        'app.orders',
        'app.clients',
        'app.types_client',
        'app.rates',
        'app.rates_clients',
        'app.client_contacts',
        'app.contact_types',
        'app.external_specialists',
        'app.order_states',
        'app.cie_ten_codes',
        'app.consultation_endings',
        'app.external_causes',
        'app.bill_types',
        'app.bills',
        'app.bill_resolutions',
        'app.resolution_concepts',
        'app.orders_bills',
        'app.payments',
        'app.form_payments',
        'app.bill_details',
        'app.order_appointments',
        'app.payments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Results') ? [] : ['className' => 'App\Model\Table\ResultsTable'];
        $this->Results = TableRegistry::get('Results', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Results);

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
