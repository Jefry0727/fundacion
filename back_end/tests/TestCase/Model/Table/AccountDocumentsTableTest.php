<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccountDocumentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccountDocumentsTable Test Case
 */
class AccountDocumentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AccountDocumentsTable
     */
    public $AccountDocuments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.account_documents'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AccountDocuments') ? [] : ['className' => 'App\Model\Table\AccountDocumentsTable'];
        $this->AccountDocuments = TableRegistry::get('AccountDocuments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AccountDocuments);

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
