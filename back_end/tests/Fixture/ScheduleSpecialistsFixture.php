<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ScheduleSpecialistsFixture
 *
 */
class ScheduleSpecialistsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'specialists_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'day' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'day of the week: 0 to 6 days

', 'precision' => null, 'autoIncrement' => null],
        'time_ini' => ['type' => 'time', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'time_end' => ['type' => 'time', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'description' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'schedule_specialist_types_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'medical_offices_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_schedules_has_specialists_specialists1_idx' => ['type' => 'index', 'columns' => ['specialists_id'], 'length' => []],
            'fk_schedule_specialists_schedule_specialist_types1_idx' => ['type' => 'index', 'columns' => ['schedule_specialist_types_id'], 'length' => []],
            'fk_schedule_specialists_medical_offices1_idx' => ['type' => 'index', 'columns' => ['medical_offices_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_schedule_specialists_medical_offices1' => ['type' => 'foreign', 'columns' => ['medical_offices_id'], 'references' => ['medical_offices', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_schedule_specialists_schedule_specialist_types1' => ['type' => 'foreign', 'columns' => ['schedule_specialist_types_id'], 'references' => ['schedule_specialist_types', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_schedules_has_specialists_specialists1' => ['type' => 'foreign', 'columns' => ['specialists_id'], 'references' => ['specialists', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'specialists_id' => 1,
            'created' => '2016-09-21 09:07:42',
            'modified' => '2016-09-21 09:07:42',
            'day' => 1,
            'time_ini' => '09:07:42',
            'time_end' => '09:07:42',
            'description' => 'Lorem ipsum dolor sit amet',
            'schedule_specialist_types_id' => 1,
            'medical_offices_id' => 1
        ],
    ];
}
