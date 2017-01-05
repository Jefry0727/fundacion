<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderDetailsFixture
 *
 */
class OrderDetailsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'subtotal' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'validator' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'total' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '								'],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'fecha de solicitud de cita', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'observations' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'calculated_age' => ['type' => 'string', 'length' => 11, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'discount' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'discount_type' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '0. not. 1. courtesy 2. discount ', 'precision' => null, 'autoIncrement' => null],
        'clients_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'rates_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'users_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'patients_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'external_specialists_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'service_type_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'order_types_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'centers_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_request_appointments_clients1_idx' => ['type' => 'index', 'columns' => ['clients_id'], 'length' => []],
            'fk_request_appointments_rates1_idx' => ['type' => 'index', 'columns' => ['rates_id'], 'length' => []],
            'fk_request_appointments_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
            'fk_request_appointments_patients1_idx' => ['type' => 'index', 'columns' => ['patients_id'], 'length' => []],
            'fk_order_details_external_specialists1_idx' => ['type' => 'index', 'columns' => ['external_specialists_id'], 'length' => []],
            'fk_order_details_service_type1_idx' => ['type' => 'index', 'columns' => ['service_type_id'], 'length' => []],
            'fk_order_details_order_types1_idx' => ['type' => 'index', 'columns' => ['order_types_id'], 'length' => []],
            'fk_order_details_centers1_idx' => ['type' => 'index', 'columns' => ['centers_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_order_details_centers1' => ['type' => 'foreign', 'columns' => ['centers_id'], 'references' => ['centers', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_order_details_external_specialists1' => ['type' => 'foreign', 'columns' => ['external_specialists_id'], 'references' => ['external_specialists', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_order_details_order_types1' => ['type' => 'foreign', 'columns' => ['order_types_id'], 'references' => ['order_types', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_order_details_service_type1' => ['type' => 'foreign', 'columns' => ['service_type_id'], 'references' => ['service_types', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_request_appointments_clients1' => ['type' => 'foreign', 'columns' => ['clients_id'], 'references' => ['clients', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_request_appointments_patients1' => ['type' => 'foreign', 'columns' => ['patients_id'], 'references' => ['patients', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_request_appointments_rates1' => ['type' => 'foreign', 'columns' => ['rates_id'], 'references' => ['rates', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_request_appointments_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'subtotal' => 1.5,
            'validator' => 'Lorem ipsum dolor sit amet',
            'total' => 1.5,
            'created' => '2016-07-06 15:06:01',
            'modified' => '2016-07-06 15:06:01',
            'observations' => 'Lorem ipsum dolor sit amet',
            'calculated_age' => 'Lorem ips',
            'discount' => 1.5,
            'discount_type' => 1,
            'clients_id' => 1,
            'rates_id' => 1,
            'users_id' => 1,
            'patients_id' => 1,
            'external_specialists_id' => 1,
            'service_type_id' => 1,
            'order_types_id' => 1,
            'centers_id' => 1
        ],
    ];
}
