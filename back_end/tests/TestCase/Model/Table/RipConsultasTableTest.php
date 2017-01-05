<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RipConsultasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RipConsultasTable Test Case
 */
class RipConsultasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RipConsultasTable
     */
    public $RipConsultas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rip_consultas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RipConsultas') ? [] : ['className' => 'App\Model\Table\RipConsultasTable'];
        $this->RipConsultas = TableRegistry::get('RipConsultas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RipConsultas);

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
