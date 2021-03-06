<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PaymentAccountsBillsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PaymentAccountsBillsTable Test Case
 */
class PaymentAccountsBillsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PaymentAccountsBillsTable
     */
    public $PaymentAccountsBills;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.payment_accounts_bills',
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
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.studies_medical_offices',
        'app.services',
        'app.products_studies',
        'app.instructives',
        'app.instructive_studies',
        'app.appointment_dates',
        'app.appointment_states',
        'app.order_appointments',
        'app.payments',
        'app.form_payments',
        'app.payments',
        'app.bill_details'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PaymentAccountsBills') ? [] : ['className' => 'App\Model\Table\PaymentAccountsBillsTable'];
        $this->PaymentAccountsBills = TableRegistry::get('PaymentAccountsBills', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PaymentAccountsBills);

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
