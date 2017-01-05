<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AppointmentDatesFixture
 *
 */
class AppointmentDatesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'appointments_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'users_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'date_time_ini' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'date_time_end' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'appointment_states_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_appointment_dates_appointments1_idx' => ['type' => 'index', 'columns' => ['appointments_id'], 'length' => []],
            'fk_appointment_dates_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
            'fk_appointment_dates_appointment_states1_idx' => ['type' => 'index', 'columns' => ['appointment_states_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_appointment_dates_appointment_states1' => ['type' => 'foreign', 'columns' => ['appointment_states_id'], 'references' => ['appointment_states', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_appointment_dates_appointments1' => ['type' => 'foreign', 'columns' => ['appointments_id'], 'references' => ['appointments', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_appointment_dates_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'appointments_id' => 1,
            'created' => '2016-06-24 10:19:16',
            'modified' => '2016-06-24 10:19:16',
            'users_id' => 1,
            'date_time_ini' => '2016-06-24 10:19:16',
            'date_time_end' => '2016-06-24 10:19:16',
            'appointment_states_id' => 1
        ],
    ];
}
