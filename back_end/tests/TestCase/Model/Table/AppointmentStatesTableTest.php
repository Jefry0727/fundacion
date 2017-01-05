<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AppointmentStatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AppointmentStatesTable Test Case
 */
class AppointmentStatesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AppointmentStatesTable
     */
    public $AppointmentStates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.appointment_states'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AppointmentStates') ? [] : ['className' => 'App\Model\Table\AppointmentStatesTable'];
        $this->AppointmentStates = TableRegistry::get('AppointmentStates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AppointmentStates);

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
