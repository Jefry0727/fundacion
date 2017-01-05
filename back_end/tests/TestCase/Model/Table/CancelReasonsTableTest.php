<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CancelReasonsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CancelReasonsTable Test Case
 */
class CancelReasonsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CancelReasonsTable
     */
    public $CancelReasons;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cancel_reasons',
        'app.appointment_dates',
        'app.appointments',
        'app.medical_offices',
        'app.studies',
        'app.specializations',
        'app.service_types',
        'app.products',
        'app.products_studies',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.studies_medical_offices',
        'app.specialists',
        'app.people',
        'app.document_types',
        'app.patients',
        'app.users',
        'app.roles',
        'app.zones',
        'app.regimes',
        'app.studies_specialists',
        'app.schedule_specialists',
        'app.schedule_specialist_types',
        'app.attentions',
        'app.order_details',
        'app.clients',
        'app.municipalities',
        'app.departments',
        'app.rates',
        'app.rates_clients',
        'app.external_specialists',
        'app.order_types',
        'app.centers',
        'app.orders',
        'app.order_states',
        'app.order_detail_appointments',
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
        $config = TableRegistry::exists('CancelReasons') ? [] : ['className' => 'App\Model\Table\CancelReasonsTable'];
        $this->CancelReasons = TableRegistry::get('CancelReasons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CancelReasons);

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
