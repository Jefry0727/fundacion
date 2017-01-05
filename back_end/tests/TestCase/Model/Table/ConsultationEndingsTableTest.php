<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsultationEndingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsultationEndingsTable Test Case
 */
class ConsultationEndingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsultationEndingsTable
     */
    public $ConsultationEndings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.consultation_endings'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ConsultationEndings') ? [] : ['className' => 'App\Model\Table\ConsultationEndingsTable'];
        $this->ConsultationEndings = TableRegistry::get('ConsultationEndings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ConsultationEndings);

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
