<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BusinessUnitsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BusinessUnitsTable Test Case
 */
class BusinessUnitsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BusinessUnitsTable
     */
    public $BusinessUnits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.business_units'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('BusinessUnits') ? [] : ['className' => 'App\Model\Table\BusinessUnitsTable'];
        $this->BusinessUnits = TableRegistry::get('BusinessUnits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BusinessUnits);

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
}
