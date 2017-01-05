<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StorageInputsFixture
 *
 */
class StorageInputsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'quant_input' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'remaining' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'observations' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'single_value' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'value' => ['type' => 'float', 'length' => 20, 'precision' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'bill_code' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'state' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '0 : inactivo ,1 Activo  ', 'precision' => null, 'autoIncrement' => null],
        'inputDate' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'iva' => ['type' => 'float', 'length' => 4, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'subtotal_value' => ['type' => 'float', 'length' => 20, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'storage_ubications_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'product_details_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'discount' => ['type' => 'float', 'length' => 20, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_inputs_storage_ubications1_idx' => ['type' => 'index', 'columns' => ['storage_ubications_id'], 'length' => []],
            'fk_storage_inputs_product_details1_idx' => ['type' => 'index', 'columns' => ['product_details_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_inputs_storage_ubications1' => ['type' => 'foreign', 'columns' => ['storage_ubications_id'], 'references' => ['storage_ubications', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_storage_inputs_product_details1' => ['type' => 'foreign', 'columns' => ['product_details_id'], 'references' => ['product_details', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'created' => '2017-01-02 16:49:00',
            'modified' => '2017-01-02 16:49:00',
            'state' => 1,
            'inputDate' => '2017-01-02',
            'iva' => 1,
            'subtotal_value' => 1,
            'storage_ubications_id' => 1,
            'product_details_id' => 1,
            'discount' => 1
        ],
    ];
}
