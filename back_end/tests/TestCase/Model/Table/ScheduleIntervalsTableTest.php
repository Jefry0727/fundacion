<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ScheduleIntervalsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ScheduleIntervalsTable Test Case
 */
class ScheduleIntervalsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ScheduleIntervalsTable
     */
    public $ScheduleIntervals;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.schedule_intervals',
        'app.medical_offices',
        'app.users',
        'app.roles',
        'app.people'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ScheduleIntervals') ? [] : ['className' => 'App\Model\Table\ScheduleIntervalsTable'];
        $this->ScheduleIntervals = TableRegistry::get('ScheduleIntervals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ScheduleIntervals);

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
