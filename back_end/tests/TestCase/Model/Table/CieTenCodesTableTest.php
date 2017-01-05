<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CieTenCodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CieTenCodesTable Test Case
 */
class CieTenCodesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CieTenCodesTable
     */
    public $CieTenCodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cie_ten_codes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CieTenCodes') ? [] : ['className' => 'App\Model\Table\CieTenCodesTable'];
        $this->CieTenCodes = TableRegistry::get('CieTenCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CieTenCodes);

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
