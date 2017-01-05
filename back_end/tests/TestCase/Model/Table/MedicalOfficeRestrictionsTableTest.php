<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MedicalOfficeRestrictionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MedicalOfficeRestrictionsTable Test Case
 */
class MedicalOfficeRestrictionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MedicalOfficeRestrictionsTable
     */
    public $MedicalOfficeRestrictions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.medical_office_restrictions',
        'app.medical_offices'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MedicalOfficeRestrictions') ? [] : ['className' => 'App\Model\Table\MedicalOfficeRestrictionsTable'];
        $this->MedicalOfficeRestrictions = TableRegistry::get('MedicalOfficeRestrictions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MedicalOfficeRestrictions);

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
