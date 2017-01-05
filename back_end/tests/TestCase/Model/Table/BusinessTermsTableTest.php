<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BusinessTermsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BusinessTermsTable Test Case
 */
class BusinessTermsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BusinessTermsTable
     */
    public $BusinessTerms;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.business_terms'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('BusinessTerms') ? [] : ['className' => 'App\Model\Table\BusinessTermsTable'];
        $this->BusinessTerms = TableRegistry::get('BusinessTerms', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BusinessTerms);

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
