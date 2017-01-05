<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderDetailAppointmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderDetailAppointmentsTable Test Case
 */
class OrderDetailAppointmentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderDetailAppointmentsTable
     */
    public $OrderDetailAppointments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.order_detail_appointments',
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
        'app.service_types',
        'app.order_types',
        'app.centers',
        'app.appointments',
        'app.medical_offices',
        'app.studies',
        'app.specializations',
        'app.products',
        'app.products_studies',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.studies_medical_offices',
        'app.specialists',
        'app.studies_specialists',
        'app.schedule_specialists',
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
        $config = TableRegistry::exists('OrderDetailAppointments') ? [] : ['className' => 'App\Model\Table\OrderDetailAppointmentsTable'];
        $this->OrderDetailAppointments = TableRegistry::get('OrderDetailAppointments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrderDetailAppointments);

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
