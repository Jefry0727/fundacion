<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PruebaUsuarioTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PruebaUsuarioTable Test Case
 */
class PruebaUsuarioTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PruebaUsuarioTable
     */
    public $PruebaUsuario;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.prueba_usuario'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PruebaUsuario') ? [] : ['className' => 'App\Model\Table\PruebaUsuarioTable'];
        $this->PruebaUsuario = TableRegistry::get('PruebaUsuario', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PruebaUsuario);

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
