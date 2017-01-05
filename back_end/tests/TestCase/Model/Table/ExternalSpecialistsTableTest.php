<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExternalSpecialistsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExternalSpecialistsTable Test Case
 */
class ExternalSpecialistsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ExternalSpecialistsTable
     */
    public $ExternalSpecialists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.external_specialists'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ExternalSpecialists') ? [] : ['className' => 'App\Model\Table\ExternalSpecialistsTable'];
        $this->ExternalSpecialists = TableRegistry::get('ExternalSpecialists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ExternalSpecialists);

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
