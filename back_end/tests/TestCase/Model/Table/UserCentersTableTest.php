<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserCentersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserCentersTable Test Case
 */
class UserCentersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserCentersTable
     */
    public $UserCenters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_centers',
        'app.users',
        'app.roles',
        'app.people',
        'app.document_types',
        'app.patients',
        'app.zones',
        'app.regimes',
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
        $config = TableRegistry::exists('UserCenters') ? [] : ['className' => 'App\Model\Table\UserCentersTable'];
        $this->UserCenters = TableRegistry::get('UserCenters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserCenters);

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
