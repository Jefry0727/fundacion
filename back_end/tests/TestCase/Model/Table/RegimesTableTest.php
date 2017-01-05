<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RegimesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RegimesTable Test Case
 */
class RegimesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RegimesTable
     */
    public $Regimes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.regimes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Regimes') ? [] : ['className' => 'App\Model\Table\RegimesTable'];
        $this->Regimes = TableRegistry::get('Regimes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Regimes);

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
