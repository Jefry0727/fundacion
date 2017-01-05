<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StudiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StudiesTable Test Case
 */
class StudiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StudiesTable
     */
    public $Studies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.studies',
        'app.specializations',
        'app.cost_centers',
        'app.business_units',
        'app.format_types',
        'app.control_formats',
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
        'app.studies_medical_offices',
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
        'app.service_types',
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
        'app.payments',
        'app.results',
        'app.specialists',
        'app.studies_specialists',
        'app.schedule_specialists',
        'app.schedule_specialist_types',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.products',
        'app.section',
        'app.logging',
        'app.logging_sections',
        'app.logging_actions',
        'app.farmaseutic_form',
        'app.manual_bills',
        'app.manual_bills_products',
        'app.products_studies',
        'app.services',
        'app.invima_codes',
        'app.products_details',
        'app.invima_code_products',
        'app.instructives',
        'app.instructive_studies'
        'app.informed_consents',
        'app.studies_informed_consents'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Studies') ? [] : ['className' => 'App\Model\Table\StudiesTable'];
        $this->Studies = TableRegistry::get('Studies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Studies);

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
