<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BillDetailsItemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BillDetailsItemsTable Test Case
 */
class BillDetailsItemsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BillDetailsItemsTable
     */
    public $BillDetailsItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bill_details_items',
        'app.items',
        'app.bill_details',
        'app.bills',
        'app.bill_resolutions',
        'app.resolution_concepts',
        'app.centers',
        'app.bill_types',
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
        'app.cost_centers',
        'app.business_units',
        'app.orders_bills',
        'app.appointments',
        'app.medical_offices',
        'app.studies',
        'app.specializations',
        'app.format_types',
        'app.control_formats',
        'app.attentions',
        'app.results',
        'app.specialists',
        'app.studies_specialists',
        'app.schedule_specialists',
        'app.schedule_specialist_types',
        'app.products',
        'app.section',
        'app.logging',
        'app.logging_sections',
        'app.logging_actions',
        'app.farmaseutic_form',
        'app.manual_bills',
        'app.form_payments',
        'app.manual_bills_products',
        'app.products_studies',
        'app.services',
        'app.invima_codes',
        'app.products_details',
        'app.invima_code_products',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.studies_medical_offices',
        'app.instructives',
        'app.instructive_studies',
        'app.appointment_dates',
        'app.appointment_states',
        'app.order_appointments',
        'app.payments',
        'app.payment_type',
        'app.payments',
        'app.item_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('BillDetailsItems') ? [] : ['className' => 'App\Model\Table\BillDetailsItemsTable'];
        $this->BillDetailsItems = TableRegistry::get('BillDetailsItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BillDetailsItems);

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
