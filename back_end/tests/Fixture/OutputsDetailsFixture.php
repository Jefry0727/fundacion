<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OutputsDetailsFixture
 *
 */
class OutputsDetailsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'output_code' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quant_output' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'value' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'storage_ubications_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'units_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'products_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'outputs_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'state' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '0 : inactivo ,1 Activo  ', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_outptus_details_storage_ubications1_idx' => ['type' => 'index', 'columns' => ['storage_ubications_id'], 'length' => []],
            'fk_outptus_details_units1_idx' => ['type' => 'index', 'columns' => ['units_id'], 'length' => []],
            'fk_outptus_details_products1_idx' => ['type' => 'index', 'columns' => ['products_id'], 'length' => []],
            'fk_outptus_details_outputs1_idx' => ['type' => 'index', 'columns' => ['outputs_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_outptus_details_outputs1' => ['type' => 'foreign', 'columns' => ['outputs_id'], 'references' => ['outputs', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_outptus_details_products1' => ['type' => 'foreign', 'columns' => ['products_id'], 'references' => ['products', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_outptus_details_storage_ubications1' => ['type' => 'foreign', 'columns' => ['storage_ubications_id'], 'references' => ['storage_ubications', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_outptus_details_units1' => ['type' => 'foreign', 'columns' => ['units_id'], 'references' => ['units', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'output_code' => 1,
            'quant_output' => 1,
            'value' => 1,
            'created' => '2016-08-04 16:16:03',
            'modified' => '2016-08-04 16:16:03',
            'storage_ubications_id' => 1,
            'units_id' => 1,
            'products_id' => 1,
            'outputs_id' => 1,
            'state' => 1
        ],
    ];
}
