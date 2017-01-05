<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AccountFixture
 *
 */
class AccountFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'account';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'account_documents_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cost_centers_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'auxiliar' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'description' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'debit_pcga' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'credit_pcga' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'nit' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'social_reazon' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'debit_altern_pcga' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => ''],
        'credit_altern_pcga' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => ''],
        'cpto_cash_flow' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '	', 'precision' => null, 'fixed' => null],
        'desc_cpto_cash_flow' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'notes' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'base_gravable_pcga' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => ''],
        'docto_banc' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'debit_niif' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'credit_niif' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'debit_altern_niif' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'credit_altern_niif' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'base_gravable_niif' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'debit_ajust' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'credit_ajust' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'debit_altern_ajust' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'credit_altern_ajust' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'base_gravable_ajust' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        'state' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '1:activo,
0:inactivo', 'precision' => null, 'autoIncrement' => null],
        'send_interfaz' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '1: send, enviado 
0, not send, sin enviar.', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'date_send' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'users_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'entitys_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_account_account_documents1_idx' => ['type' => 'index', 'columns' => ['account_documents_id'], 'length' => []],
            'fk_account_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
            'fk_account_cost_centers1_idx' => ['type' => 'index', 'columns' => ['cost_centers_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_account_account_documents1' => ['type' => 'foreign', 'columns' => ['account_documents_id'], 'references' => ['account_documents', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_account_cost_centers1' => ['type' => 'foreign', 'columns' => ['cost_centers_id'], 'references' => ['cost_centers', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_account_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'account_documents_id' => 1,
            'cost_centers_id' => 1,
            'auxiliar' => 1,
            'description' => 'Lorem ipsum dolor sit amet',
            'debit_pcga' => 1,
            'credit_pcga' => 1,
            'nit' => 'Lorem ipsum dolor sit amet',
            'social_reazon' => 'Lorem ipsum dolor sit amet',
            'debit_altern_pcga' => 1,
            'credit_altern_pcga' => 1,
            'cpto_cash_flow' => 'Lorem ipsum dolor sit amet',
            'desc_cpto_cash_flow' => 'Lorem ipsum dolor sit amet',
            'notes' => 'Lorem ipsum dolor sit amet',
            'base_gravable_pcga' => 1,
            'docto_banc' => 'Lorem ipsum dolor sit amet',
            'debit_niif' => 1,
            'credit_niif' => 1,
            'debit_altern_niif' => 1,
            'credit_altern_niif' => 1,
            'base_gravable_niif' => 1,
            'debit_ajust' => 1,
            'credit_ajust' => 1,
            'debit_altern_ajust' => 1,
            'credit_altern_ajust' => 1,
            'base_gravable_ajust' => 1,
            'state' => 1,
            'send_interfaz' => 1,
            'created' => '2016-11-17 17:18:34',
            'modified' => '2016-11-17 17:18:34',
            'date_send' => '2016-11-17 17:18:34',
            'users_id' => 1,
            'entitys_id' => 1
        ],
    ];
}
