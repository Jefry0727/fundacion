<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccountTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccountTable Test Case
 */
class AccountTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AccountTable
     */
    public $Account;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.account',
        'app.cost_centers',
        'app.business_units',
        'app.account_documents',
        'app.users',
        'app.roles',
        'app.people',
        'app.document_types',
        'app.municipalities',
        'app.departments',
        'app.patients',
        'app.zones',
        'app.regimes',
        'app.eps',
        'app.centers',
        'app.user_centers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Account') ? [] : ['className' => 'App\Model\Table\AccountTable'];
        $this->Account = TableRegistry::get('Account', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Account);

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
