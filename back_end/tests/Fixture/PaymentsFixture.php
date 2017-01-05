<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PaymentsFixture
 *
 */
class PaymentsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'users_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'credit_card_number' => ['type' => 'string', 'length' => 25, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'debit' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'credit' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'donation' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'discount' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'copayment' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'form_payments_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'bill_types_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'bills_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'payment_type_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_paydments_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
            'fk_payments_form_payments1_idx' => ['type' => 'index', 'columns' => ['form_payments_id'], 'length' => []],
            'fk_payments_bill_types1_idx' => ['type' => 'index', 'columns' => ['bill_types_id'], 'length' => []],
            'fk_payments_bills1_idx' => ['type' => 'index', 'columns' => ['bills_id'], 'length' => []],
            'fk_payments_payment_type1_idx' => ['type' => 'index', 'columns' => ['payment_type_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_paydments_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_payments_bill_types1' => ['type' => 'foreign', 'columns' => ['bill_types_id'], 'references' => ['bill_types', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_payments_bills1' => ['type' => 'foreign', 'columns' => ['bills_id'], 'references' => ['bills', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_payments_form_payments1' => ['type' => 'foreign', 'columns' => ['form_payments_id'], 'references' => ['form_payments', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_payments_payment_type1' => ['type' => 'foreign', 'columns' => ['payment_type_id'], 'references' => ['payment_type', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'users_id' => 1,
            'credit_card_number' => 'Lorem ipsum dolor sit a',
            'debit' => 1.5,
            'credit' => 1.5,
            'donation' => 1.5,
            'discount' => 1.5,
            'copayment' => 1.5,
            'form_payments_id' => 1,
            'bill_types_id' => 1,
            'created' => '2016-12-19 10:34:29',
            'bills_id' => 1,
            'payment_type_id' => 1
        ],
    ];
}
