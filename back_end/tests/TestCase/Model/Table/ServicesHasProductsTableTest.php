<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ServicesHasProductsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ServicesHasProductsTable Test Case
 */
class ServicesHasProductsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ServicesHasProductsTable
     */
    public $ServicesHasProducts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.services_has_products',
        'app.services',
        'app.products',
        'app.section',
        'app.logging',
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
        'app.logging_sections',
        'app.logging_actions',
        'app.farmaseutic_form',
        'app.manual_bills',
        'app.bill_resolutions',
        'app.resolution_concepts',
        'app.bill_types',
        'app.form_payments',
        'app.manual_bills_products',
        'app.studies',
        'app.specializations',
        'app.cost_centers',
        'app.format_types',
        'app.control_formats',
        'app.attentions',
        'app.appointments',
        'app.medical_offices',
        'app.studies_medical_offices',
        'app.appointment_dates',
        'app.appointment_states',
        'app.orders',
        'app.clients',
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
        'app.bills',
        'app.orders_bills',
        'app.order_appointments',
        'app.payments',
        'app.results',
        'app.specialists',
        'app.studies_specialists',
        'app.schedule_specialists',
        'app.schedule_specialist_types',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.products_studies',
        'app.instructives',
        'app.instructive_studies',
        'app.invima_codes',
        'app.products_details',
        'app.invima_code_products'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ServicesHasProducts') ? [] : ['className' => 'App\Model\Table\ServicesHasProductsTable'];
        $this->ServicesHasProducts = TableRegistry::get('ServicesHasProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ServicesHasProducts);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
