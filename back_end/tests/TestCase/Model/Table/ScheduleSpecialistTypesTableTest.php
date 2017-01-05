<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ScheduleSpecialistTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ScheduleSpecialistTypesTable Test Case
 */
class ScheduleSpecialistTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ScheduleSpecialistTypesTable
     */
    public $ScheduleSpecialistTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.schedule_specialist_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ScheduleSpecialistTypes') ? [] : ['className' => 'App\Model\Table\ScheduleSpecialistTypesTable'];
        $this->ScheduleSpecialistTypes = TableRegistry::get('ScheduleSpecialistTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ScheduleSpecialistTypes);

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
