<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StudiesMedicalOfficesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StudiesMedicalOfficesTable Test Case
 */
class StudiesMedicalOfficesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StudiesMedicalOfficesTable
     */
    public $StudiesMedicalOffices;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.studies_medical_offices',
        'app.studies',
        'app.specializations',
        'app.service_types',
        'app.products',
        'app.products_studies',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.medical_offices',
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
        'app.studies_specialists'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('StudiesMedicalOffices') ? [] : ['className' => 'App\Model\Table\StudiesMedicalOfficesTable'];
        $this->StudiesMedicalOffices = TableRegistry::get('StudiesMedicalOffices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StudiesMedicalOffices);

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
