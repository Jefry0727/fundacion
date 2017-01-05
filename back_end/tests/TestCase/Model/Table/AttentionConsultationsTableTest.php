<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AttentionConsultationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AttentionConsultationsTable Test Case
 */
class AttentionConsultationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AttentionConsultationsTable
     */
    public $AttentionConsultations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.attention_consultations',
        'app.orders',
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
        'app.order_states',
        'app.specialists',
        'app.studies',
        'app.specializations',
        'app.products',
        'app.products_studies',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.medical_offices',
        'app.studies_medical_offices',
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
        $config = TableRegistry::exists('AttentionConsultations') ? [] : ['className' => 'App\Model\Table\AttentionConsultationsTable'];
        $this->AttentionConsultations = TableRegistry::get('AttentionConsultations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AttentionConsultations);

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
