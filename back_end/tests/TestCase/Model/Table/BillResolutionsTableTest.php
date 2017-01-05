<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BillResolutionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BillResolutionsTable Test Case
 */
class BillResolutionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BillResolutionsTable
     */
    public $BillResolutions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bill_resolutions',
        'app.resolution_concepts',
        'app.centers',
        'app.bill_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('BillResolutions') ? [] : ['className' => 'App\Model\Table\BillResolutionsTable'];
        $this->BillResolutions = TableRegistry::get('BillResolutions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BillResolutions);

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
