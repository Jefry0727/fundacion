<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RipProcedimientosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RipProcedimientosTable Test Case
 */
class RipProcedimientosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RipProcedimientosTable
     */
    public $RipProcedimientos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rip_procedimientos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RipProcedimientos') ? [] : ['className' => 'App\Model\Table\RipProcedimientosTable'];
        $this->RipProcedimientos = TableRegistry::get('RipProcedimientos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RipProcedimientos);

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
