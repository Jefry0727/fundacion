<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InvimaCodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InvimaCodesTable Test Case
 */
class InvimaCodesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InvimaCodesTable
     */
    public $InvimaCodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.invima_codes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('InvimaCodes') ? [] : ['className' => 'App\Model\Table\InvimaCodesTable'];
        $this->InvimaCodes = TableRegistry::get('InvimaCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InvimaCodes);

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
