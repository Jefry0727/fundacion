<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RipControlesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RipControlesTable Test Case
 */
class RipControlesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RipControlesTable
     */
    public $RipControles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rip_controles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RipControles') ? [] : ['className' => 'App\Model\Table\RipControlesTable'];
        $this->RipControles = TableRegistry::get('RipControles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RipControles);

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
