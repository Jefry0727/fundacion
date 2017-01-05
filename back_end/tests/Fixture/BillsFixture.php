<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillsFixture
 *
 */
class BillsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'bill_number' => ['type' => 'string', 'length' => 25, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'bill_resolutions_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'orders_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'users_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_bills_bill_resolutions1_idx' => ['type' => 'index', 'columns' => ['bill_resolutions_id'], 'length' => []],
            'fk_bills_orders1_idx' => ['type' => 'index', 'columns' => ['orders_id'], 'length' => []],
            'fk_bills_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'number_UNIQUE' => ['type' => 'unique', 'columns' => ['bill_number'], 'length' => []],
            'fk_bills_bill_resolutions1' => ['type' => 'foreign', 'columns' => ['bill_resolutions_id'], 'references' => ['bill_resolutions', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_bills_orders1' => ['type' => 'foreign', 'columns' => ['orders_id'], 'references' => ['orders', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_bills_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'bill_number' => 'Lorem ipsum dolor sit a',
            'bill_resolutions_id' => 1,
            'orders_id' => 1,
            'users_id' => 1
        ],
    ];
}
