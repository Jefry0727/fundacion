<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResultProfilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResultProfilesTable Test Case
 */
class ResultProfilesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResultProfilesTable
     */
    public $ResultProfiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.result_profiles',
        'app.specialists',
        'app.people',
        'app.document_types',
        'app.patients',
        'app.users',
        'app.roles',
        'app.zones',
        'app.regimes',
        'app.studies',
        'app.specializations',
        'app.service_types',
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
        $config = TableRegistry::exists('ResultProfiles') ? [] : ['className' => 'App\Model\Table\ResultProfilesTable'];
        $this->ResultProfiles = TableRegistry::get('ResultProfiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResultProfiles);

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
