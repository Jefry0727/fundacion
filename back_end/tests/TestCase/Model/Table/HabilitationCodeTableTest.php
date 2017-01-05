<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HabilitationCodeTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HabilitationCodeTable Test Case
 */
class HabilitationCodeTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\HabilitationCodeTable
     */
    public $HabilitationCode;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.habilitation_code',
        'app.centers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('HabilitationCode') ? [] : ['className' => 'App\Model\Table\HabilitationCodeTable'];
        $this->HabilitationCode = TableRegistry::get('HabilitationCode', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HabilitationCode);

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
