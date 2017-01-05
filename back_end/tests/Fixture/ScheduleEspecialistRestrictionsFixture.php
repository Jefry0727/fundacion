<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ScheduleEspecialistRestrictionsFixture
 *
 */
class ScheduleEspecialistRestrictionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'Id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'description' => ['type' => 'string', 'length' => 80, 'null' => true, 'default' => null, 'comment' => '	', 'precision' => null, 'fixed' => null],
        'date_ini' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '	', 'precision' => null],
        'date_end' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'specialists_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_schedule_especialist_restrictions_specialists1_idx' => ['type' => 'index', 'columns' => ['specialists_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['Id'], 'length' => []],
            'fk_schedule_especialist_restrictions_specialists1' => ['type' => 'foreign', 'columns' => ['specialists_id'], 'references' => ['specialists', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'Id' => 1,
            'description' => 'Lorem ipsum dolor sit amet',
            'date_ini' => '2016-09-21 08:07:47',
            'date_end' => '2016-09-21 08:07:47',
            'specialists_id' => 1
        ],
    ];
}
