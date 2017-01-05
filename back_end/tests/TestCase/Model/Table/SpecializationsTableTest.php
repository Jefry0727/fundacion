<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SpecializationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SpecializationsTable Test Case
 */
class SpecializationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SpecializationsTable
     */
    public $Specializations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.specializations',
        'app.studies',
        'app.format_types',
        'app.control_formats',
        'app.attentions',
        'app.users',
        'app.roles',
        'app.people',
        'app.document_types',
        'app.patients',
        'app.zones',
        'app.regimes',
        'app.appointments',
        'app.medical_offices',
        'app.studies_medical_offices',
        'app.appointment_dates',
        'app.appointment_states',
        'app.orders',
        'app.clients',
        'app.municipalities',
        'app.departments',
        'app.rates',
        'app.rates_clients',
        'app.external_specialists',
        'app.service_types',
        'app.centers',
        'app.order_states',
        'app.cie_ten_codes',
        'app.consultation_endings',
        'app.external_causes',
        'app.cost_centers',
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
        'app.products',
        'app.products_studies'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Specializations') ? [] : ['className' => 'App\Model\Table\SpecializationsTable'];
        $this->Specializations = TableRegistry::get('Specializations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Specializations);

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
