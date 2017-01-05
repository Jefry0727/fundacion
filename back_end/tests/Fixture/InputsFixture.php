<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InputsFixture
 *
 */
class InputsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quant_input' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'remaining' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'observations' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'single_value' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'value' => ['type' => 'biginteger', 'length' => 15, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'bill_code' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'expiration_date' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'lot' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'temperature' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'temp_store' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'order_code' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'products_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'providers_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'storage_ubications_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'marks_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'users_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'invima_codes_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'units_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'state' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '0 : inactivo ,1 Activo  ', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_inputs_products1_idx' => ['type' => 'index', 'columns' => ['products_id'], 'length' => []],
            'fk_inputs_providers1_idx' => ['type' => 'index', 'columns' => ['providers_id'], 'length' => []],
            'fk_inputs_storage_ubications1_idx' => ['type' => 'index', 'columns' => ['storage_ubications_id'], 'length' => []],
            'fk_inputs_marks1_idx' => ['type' => 'index', 'columns' => ['marks_id'], 'length' => []],
            'fk_inputs_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
            'fk_inputs_invima_codes1_idx' => ['type' => 'index', 'columns' => ['invima_codes_id'], 'length' => []],
            'fk_inputs_units1_idx' => ['type' => 'index', 'columns' => ['units_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_inputs_invima_codes1' => ['type' => 'foreign', 'columns' => ['invima_codes_id'], 'references' => ['invima_codes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_inputs_marks1' => ['type' => 'foreign', 'columns' => ['marks_id'], 'references' => ['marks', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_inputs_products1' => ['type' => 'foreign', 'columns' => ['products_id'], 'references' => ['products', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_inputs_providers1' => ['type' => 'foreign', 'columns' => ['providers_id'], 'references' => ['providers', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_inputs_storage_ubications1' => ['type' => 'foreign', 'columns' => ['storage_ubications_id'], 'references' => ['storage_ubications', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_inputs_units1' => ['type' => 'foreign', 'columns' => ['units_id'], 'references' => ['units', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_inputs_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'quant_input' => 1,
            'remaining' => 1,
            'observations' => 'Lorem ipsum dolor sit amet',
            'single_value' => 1,
            'value' => 1,
            'bill_code' => 'Lorem ipsum dolor sit amet',
            'expiration_date' => '2016-08-04',
            'lot' => 'Lorem ipsum dolor sit amet',
            'temperature' => 'Lorem ipsum dolor sit amet',
            'temp_store' => 'Lorem ipsum dolor sit amet',
            'order_code' => 'Lorem ipsum dolor sit amet',
            'created' => '2016-08-04 16:13:14',
            'modified' => '2016-08-04 16:13:14',
            'products_id' => 1,
            'providers_id' => 1,
            'storage_ubications_id' => 1,
            'marks_id' => 1,
            'users_id' => 1,
            'invima_codes_id' => 1,
            'units_id' => 1,
            'state' => 1
        ],
    ];
}
