<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CostCentersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CostCentersTable Test Case
 */
class CostCentersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CostCentersTable
     */
    public $CostCenters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cost_centers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CostCenters') ? [] : ['className' => 'App\Model\Table\CostCentersTable'];
        $this->CostCenters = TableRegistry::get('CostCenters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CostCenters);

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
