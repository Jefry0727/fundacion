<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AppointmentDatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AppointmentDatesTable Test Case
 */
class AppointmentDatesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AppointmentDatesTable
     */
    public $AppointmentDates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.appointment_dates',
        'app.appointments',
        'app.medical_offices',
        'app.order_details',
        'app.clients',
        'app.municipalities',
        'app.departments',
        'app.rates',
        'app.rates_clients',
        'app.users',
        'app.roles',
        'app.people',
        'app.document_types',
        'app.patients',
        'app.zones',
        'app.regimes',
        'app.external_specialists',
        'app.order_states',
        'app.service_types',
        'app.order_types',
        'app.studies',
        'app.specializations',
        'app.service_type',
        'app.products',
        'app.products_studies',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.studies_medical_offices',
        'app.specialists',
        'app.schedule',
        'app.schedule_specialists',
        'app.studies_specialists',
        'app.appointment_states'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AppointmentDates') ? [] : ['className' => 'App\Model\Table\AppointmentDatesTable'];
        $this->AppointmentDates = TableRegistry::get('AppointmentDates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AppointmentDates);

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
