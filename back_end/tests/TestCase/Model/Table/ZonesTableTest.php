<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ZonesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ZonesTable Test Case
 */
class ZonesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ZonesTable
     */
    public $Zones;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.zones',
        'app.patients',
        'app.users',
        'app.roles',
        'app.people',
        'app.document_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Zones') ? [] : ['className' => 'App\Model\Table\ZonesTable'];
        $this->Zones = TableRegistry::get('Zones', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Zones);

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
