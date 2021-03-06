<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ScheduleSpecialistsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ScheduleSpecialistsTable Test Case
 */
class ScheduleSpecialistsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ScheduleSpecialistsTable
     */
    public $ScheduleSpecialists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.schedule_specialists',
        'app.specialists',
        'app.people',
        'app.document_types',
        'app.municipalities',
        'app.departments',
        'app.patients',
        'app.users',
        'app.roles',
        'app.centers',
        'app.user_centers',
        'app.zones',
        'app.regimes',
        'app.eps',
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
        'app.order_appointments',
        'app.bills',
        'app.bill_resolutions',
        'app.resolution_concepts',
        'app.bill_types',
        'app.orders_bills',
        'app.payments',
        'app.form_payments',
        'app.results',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.studies_specialists',
        'app.products',
        'app.section',
        'app.logging',
        'app.logging_sections',
        'app.logging_actions',
        'app.farmaseutic_form',
        'app.manual_bills',
        'app.manual_bills_products',
        'app.products_studies',
        'app.invima_codes',
        'app.products_details',
        'app.invima_code_products',
        'app.instructives',
        'app.instructive_studies',
        'app.schedule_specialist_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ScheduleSpecialists') ? [] : ['className' => 'App\Model\Table\ScheduleSpecialistsTable'];
        $this->ScheduleSpecialists = TableRegistry::get('ScheduleSpecialists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ScheduleSpecialists);

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
