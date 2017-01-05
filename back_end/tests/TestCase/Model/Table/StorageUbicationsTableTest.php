<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StorageUbicationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StorageUbicationsTable Test Case
 */
class StorageUbicationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StorageUbicationsTable
     */
    public $StorageUbications;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.storage_ubications',
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
        $config = TableRegistry::exists('StorageUbications') ? [] : ['className' => 'App\Model\Table\StorageUbicationsTable'];
        $this->StorageUbications = TableRegistry::get('StorageUbications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StorageUbications);

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
