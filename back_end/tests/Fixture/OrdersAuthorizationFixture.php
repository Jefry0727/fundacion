<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersAuthorizationFixture
 *
 */
class OrdersAuthorizationFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'orders_authorization';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'observations' => ['type' => 'string', 'length' => 2000, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'state' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '0 -> No Autorizado
1 -> Autorizado', 'precision' => null, 'autoIncrement' => null],
        'orders_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'users_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_orders_authorization_orders1_idx' => ['type' => 'index', 'columns' => ['orders_id'], 'length' => []],
            'fk_orders_authorization_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_orders_authorization_orders1' => ['type' => 'foreign', 'columns' => ['orders_id'], 'references' => ['orders', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_orders_authorization_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'observations' => 'Lorem ipsum dolor sit amet',
            'created' => '2016-11-17 10:26:22',
            'state' => 1,
            'orders_id' => 1,
            'users_id' => 1
        ],
    ];
}
