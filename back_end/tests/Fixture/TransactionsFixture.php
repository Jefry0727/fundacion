<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TransactionsFixture
 *
 */
class TransactionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'transfers_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'inputs_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'outputs_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_itos_transfers1_idx' => ['type' => 'index', 'columns' => ['transfers_id'], 'length' => []],
            'fk_itos_inputs1_idx' => ['type' => 'index', 'columns' => ['inputs_id'], 'length' => []],
            'fk_transactions_outputs1_idx' => ['type' => 'index', 'columns' => ['outputs_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_itos_inputs1' => ['type' => 'foreign', 'columns' => ['inputs_id'], 'references' => ['inputs', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_itos_transfers1' => ['type' => 'foreign', 'columns' => ['transfers_id'], 'references' => ['transfers', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_transactions_outputs1' => ['type' => 'foreign', 'columns' => ['outputs_id'], 'references' => ['outputs', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'transfers_id' => 1,
            'inputs_id' => 1,
            'outputs_id' => 1
        ],
    ];
}
