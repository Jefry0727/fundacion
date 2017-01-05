<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RipDescripcionTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RipDescripcionTable Test Case
 */
class RipDescripcionTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RipDescripcionTable
     */
    public $RipDescripcion;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rip_descripcion'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RipDescripcion') ? [] : ['className' => 'App\Model\Table\RipDescripcionTable'];
        $this->RipDescripcion = TableRegistry::get('RipDescripcion', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RipDescripcion);

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
