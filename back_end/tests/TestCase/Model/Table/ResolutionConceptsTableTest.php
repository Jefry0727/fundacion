<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResolutionConceptsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResolutionConceptsTable Test Case
 */
class ResolutionConceptsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResolutionConceptsTable
     */
    public $ResolutionConcepts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.resolution_concepts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ResolutionConcepts') ? [] : ['className' => 'App\Model\Table\ResolutionConceptsTable'];
        $this->ResolutionConcepts = TableRegistry::get('ResolutionConcepts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResolutionConcepts);

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
