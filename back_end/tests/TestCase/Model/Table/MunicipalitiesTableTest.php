<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MunicipalitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MunicipalitiesTable Test Case
 */
class MunicipalitiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MunicipalitiesTable
     */
    public $Municipalities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('Municipalities') ? [] : ['className' => 'App\Model\Table\MunicipalitiesTable'];
        $this->Municipalities = TableRegistry::get('Municipalities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Municipalities);

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
