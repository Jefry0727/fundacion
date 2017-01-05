<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GenderTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GenderTable Test Case
 */
class GenderTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\GenderTable
     */
    public $Gender;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.gender'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Gender') ? [] : ['className' => 'App\Model\Table\GenderTable'];
        $this->Gender = TableRegistry::get('Gender', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Gender);

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
