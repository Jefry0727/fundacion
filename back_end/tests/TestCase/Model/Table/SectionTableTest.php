<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SectionTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SectionTable Test Case
 */
class SectionTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SectionTable
     */
    public $Section;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.section',
        'app.products',
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
        'app.logging',
        'app.logging_sections',
        'app.logging_actions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Section') ? [] : ['className' => 'App\Model\Table\SectionTable'];
        $this->Section = TableRegistry::get('Section', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Section);

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
}
