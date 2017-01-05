<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderDetailAppointmentsFixture
 *
 */
class OrderDetailAppointmentsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'order_details_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'appointments_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_order_details_has_appointments_appointments1_idx' => ['type' => 'index', 'columns' => ['appointments_id'], 'length' => []],
            'fk_order_details_has_appointments_order_details1_idx' => ['type' => 'index', 'columns' => ['order_details_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_order_details_has_appointments_appointments1' => ['type' => 'foreign', 'columns' => ['appointments_id'], 'references' => ['appointments', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_order_details_has_appointments_order_details1' => ['type' => 'foreign', 'columns' => ['order_details_id'], 'references' => ['order_details', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'order_details_id' => 1,
            'appointments_id' => 1,
            'created' => '2016-07-05 09:50:22',
            'modified' => '2016-07-05 09:50:22'
        ],
    ];
}
