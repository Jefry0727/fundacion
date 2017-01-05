<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ManualBillsFixture
 *
 */
class ManualBillsFixture extends TestFixture
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
        'entity_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'bill_types_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'observations' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'subtotal' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'discount' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'donation' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'total' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '								'],
        'total_cancel' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'form_payments_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'bills_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'credit_card_number' => ['type' => 'string', 'length' => 25, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'users_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'entity_type' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '0-> persona
1->entidad', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_manual_bills_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
            'fk_manual_bills_bill_types1_idx' => ['type' => 'index', 'columns' => ['bill_types_id'], 'length' => []],
            'fk_manual_bills_form_payments1_idx' => ['type' => 'index', 'columns' => ['form_payments_id'], 'length' => []],
            'fk_manual_bills_bills1_idx' => ['type' => 'index', 'columns' => ['bills_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_manual_bills_bill_types1' => ['type' => 'foreign', 'columns' => ['bill_types_id'], 'references' => ['bill_types', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_manual_bills_bills1' => ['type' => 'foreign', 'columns' => ['bills_id'], 'references' => ['bills', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_manual_bills_form_payments1' => ['type' => 'foreign', 'columns' => ['form_payments_id'], 'references' => ['form_payments', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_manual_bills_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'entity_id' => 1,
            'bill_types_id' => 1,
            'observations' => 'Lorem ipsum dolor sit amet',
            'subtotal' => 1.5,
            'discount' => 1.5,
            'donation' => 1.5,
            'total' => 1.5,
            'total_cancel' => 1.5,
            'form_payments_id' => 1,
            'bills_id' => 1,
            'credit_card_number' => 'Lorem ipsum dolor sit a',
            'users_id' => 1,
            'entity_type' => 1
        ],
    ];
}
