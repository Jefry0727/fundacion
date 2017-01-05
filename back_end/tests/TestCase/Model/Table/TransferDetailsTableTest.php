<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransferDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransferDetailsTable Test Case
 */
class TransferDetailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TransferDetailsTable
     */
    public $TransferDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.transfer_details',
        'app.inputs',
        'app.transfers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TransferDetails') ? [] : ['className' => 'App\Model\Table\TransferDetailsTable'];
        $this->TransferDetails = TableRegistry::get('TransferDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TransferDetails);

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
