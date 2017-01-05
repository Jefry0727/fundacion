<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResultStudiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResultStudiesTable Test Case
 */
class ResultStudiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResultStudiesTable
     */
    public $ResultStudies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.result_studies',
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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ResultStudies') ? [] : ['className' => 'App\Model\Table\ResultStudiesTable'];
        $this->ResultStudies = TableRegistry::get('ResultStudies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResultStudies);

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
