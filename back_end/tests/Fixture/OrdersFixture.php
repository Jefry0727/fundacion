<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersFixture
 *
 */
class OrdersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'order_consec' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'validator' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'calculated_age' => ['type' => 'string', 'length' => 11, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'observations' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'subtotal' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => ''],
        'discount' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => ''],
        'donation' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => ''],
        'total' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => '								'],
        'total_cancel' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => ''],
        'copayment' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => ''],
        'discount_type' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '0. descuento 1. donation', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'fecha de solicitud de cita', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'clients_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'rates_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'users_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'patients_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'external_specialists_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'service_type_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'centers_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'order_states_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cie_ten_codes_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'consultation_endings_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'external_causes_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cost_centers_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'bill_types_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_request_appointments_clients1_idx' => ['type' => 'index', 'columns' => ['clients_id'], 'length' => []],
            'fk_request_appointments_rates1_idx' => ['type' => 'index', 'columns' => ['rates_id'], 'length' => []],
            'fk_request_appointments_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
            'fk_request_appointments_patients1_idx' => ['type' => 'index', 'columns' => ['patients_id'], 'length' => []],
            'fk_order_details_external_specialists1_idx' => ['type' => 'index', 'columns' => ['external_specialists_id'], 'length' => []],
            'fk_order_details_service_type1_idx' => ['type' => 'index', 'columns' => ['service_type_id'], 'length' => []],
            'fk_order_details_centers1_idx' => ['type' => 'index', 'columns' => ['centers_id'], 'length' => []],
            'fk_orderss_order_states1_idx' => ['type' => 'index', 'columns' => ['order_states_id'], 'length' => []],
            'fk_orders_cie_ten_codes1_idx' => ['type' => 'index', 'columns' => ['cie_ten_codes_id'], 'length' => []],
            'fk_orders_consultation_endings1_idx' => ['type' => 'index', 'columns' => ['consultation_endings_id'], 'length' => []],
            'fk_orders_external_causes1_idx' => ['type' => 'index', 'columns' => ['external_causes_id'], 'length' => []],
            'fk_orders_cost_centers1_idx' => ['type' => 'index', 'columns' => ['cost_centers_id'], 'length' => []],
            'fk_orders_bill_types1_idx' => ['type' => 'index', 'columns' => ['bill_types_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
            'order_consec' => 'Lorem ipsum dolor ',
            'validator' => 'Lorem ipsum dolor sit amet',
            'calculated_age' => 'Lorem ips',
            'observations' => 'Lorem ipsum dolor sit amet',
            'subtotal' => 1.5,
            'discount' => 1.5,
            'donation' => 1.5,
            'total' => 1.5,
            'total_cancel' => 1.5,
            'copayment' => 1.5,
            'discount_type' => 1,
            'created' => '2016-10-07 11:45:27',
            'modified' => '2016-10-07 11:45:27',
            'clients_id' => 1,
            'rates_id' => 1,
            'users_id' => 1,
            'patients_id' => 1,
            'external_specialists_id' => 1,
            'service_type_id' => 1,
            'centers_id' => 1,
            'order_states_id' => 1,
            'cie_ten_codes_id' => 1,
            'consultation_endings_id' => 1,
            'external_causes_id' => 1,
            'cost_centers_id' => 1,
            'bill_types_id' => 1
        ],
    ];
}
