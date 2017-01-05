<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PaymentAccountsBillsFixture
 *
 */
class PaymentAccountsBillsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'payment_accounts_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'bills_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_payment_accounts_bills_payment_accounts1_idx' => ['type' => 'index', 'columns' => ['payment_accounts_id'], 'length' => []],
            'fk_payment_accounts_bills_bills1_idx' => ['type' => 'index', 'columns' => ['bills_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_payment_accounts_bills_bills1' => ['type' => 'foreign', 'columns' => ['bills_id'], 'references' => ['bills', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_payment_accounts_bills_payment_accounts1' => ['type' => 'foreign', 'columns' => ['payment_accounts_id'], 'references' => ['payment_accounts', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
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
            'payment_accounts_id' => 1,
            'bills_id' => 1
        ],
    ];
}
