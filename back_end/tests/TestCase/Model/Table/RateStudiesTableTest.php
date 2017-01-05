<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RateStudiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RateStudiesTable Test Case
 */
class RateStudiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RateStudiesTable
     */
    public $RateStudies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rate_studies',
        'app.studies',
        'app.specializations',
        'app.service_type',
        'app.products',
        'app.products_studies',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.medical_offices',
        'app.studies_medical_offices',
        'app.specialists',
        'app.people',
        'app.document_types',
        'app.patients',
        'app.users',
        'app.roles',
        'app.zones',
        'app.regimes',
        'app.schedule',
        'app.schedule_specialists',
        'app.studies_specialists',
        'app.rates_clients',
        'app.rates',
        'app.clients',
        'app.municipalities',
        'app.departments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RateStudies') ? [] : ['className' => 'App\Model\Table\RateStudiesTable'];
        $this->RateStudies = TableRegistry::get('RateStudies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RateStudies);

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
