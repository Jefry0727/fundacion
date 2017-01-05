<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AppointmentsSuppliesFixture
 *
 */
class AppointmentsSuppliesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'quantity' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'appointments_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'products_studies_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cost' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        '_indexes' => [
            'fk_appointments_ supplies_appointments1_idx' => ['type' => 'index', 'columns' => ['appointments_id'], 'length' => []],
            'fk_appointments_ supplies_products_studies1_idx' => ['type' => 'index', 'columns' => ['products_studies_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_appointments_ supplies_appointments1' => ['type' => 'foreign', 'columns' => ['appointments_id'], 'references' => ['appointments', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_appointments_ supplies_products_studies1' => ['type' => 'foreign', 'columns' => ['products_studies_id'], 'references' => ['products_studies', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'quantity' => 1,
            'created' => '2016-07-19 14:22:37',
            'modified' => '2016-07-19 14:22:37',
            'appointments_id' => 1,
            'products_studies_id' => 1,
            'cost' => 1
        ],
    ];
}
