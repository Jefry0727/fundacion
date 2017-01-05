<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MammogramTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MammogramTable Test Case
 */
class MammogramTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MammogramTable
     */
    public $Mammogram;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mammogram',
        'app.control_formats',
        'app.format_types',
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
        'app.gender',
        'app.centers',
        'app.user_centers',
        'app.appointments',
        'app.medical_offices',
        'app.studies',
        'app.specializations',
        'app.cost_centers',
        'app.business_units',
        'app.products',
        'app.section',
        'app.logging',
        'app.logging_sections',
        'app.logging_actions',
        'app.farmaseutic_form',
        'app.manual_bills',
        'app.bill_types',
        'app.form_payments',
        'app.bills',
        'app.bill_resolutions',
        'app.resolution_concepts',
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
        'app.orders_bills',
        'app.order_appointments',
        'app.payments',
        'app.payment_type',
        'app.payments',
        'app.bill_details',
        'app.bill_details_items',
        'app.item_types',
        'app.manual_bills_products',
        'app.products_studies',
        'app.services',
        'app.product_services_types',
        'app.product_services_types_services',
        'app.invima_codes',
        'app.products_details',
        'app.invima_code_products',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.studies_medical_offices',
        'app.specialists',
        'app.studies_specialists',
        'app.schedule_specialists',
        'app.schedule_specialist_types',
        'app.instructives',
        'app.instructive_studies',
        'app.appointment_dates',
        'app.appointment_states',
        'app.results'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Mammogram') ? [] : ['className' => 'App\Model\Table\MammogramTable'];
        $this->Mammogram = TableRegistry::get('Mammogram', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Mammogram);

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
