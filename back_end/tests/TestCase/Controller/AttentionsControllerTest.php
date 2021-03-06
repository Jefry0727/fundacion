<?php
namespace App\Test\TestCase\Controller;

use App\Controller\AttentionsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AttentionsController Test Case
 */
class AttentionsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        'app.studies',
        'app.specializations',
        'app.service_types',
        'app.products',
        'app.products_studies',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.studies_medical_offices',
        'app.specialists',
        'app.studies_specialists',
        'app.schedule_specialists',
        'app.schedule_specialist_types',
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
        'app.appointment_dates',
        'app.appointment_states'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
