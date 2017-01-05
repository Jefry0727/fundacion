<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TransfersFixture
 *
 */
class TransfersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'transfer_code' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'observations' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'state' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '0 : inactivo ,1 Activo  ', 'precision' => null, 'autoIncrement' => null],
        'requests_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'storage_ubications_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_transfers_requests1_idx' => ['type' => 'index', 'columns' => ['requests_id'], 'length' => []],
            'fk_transfers_storage_ubications1_idx' => ['type' => 'index', 'columns' => ['storage_ubications_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_transfers_requests1' => ['type' => 'foreign', 'columns' => ['requests_id'], 'references' => ['requests', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_transfers_storage_ubications1' => ['type' => 'foreign', 'columns' => ['storage_ubications_id'], 'references' => ['storage_ubications', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'transfer_code' => 'Lorem ipsum dolor sit amet',
            'observations' => 'Lorem ipsum dolor sit amet',
            'state' => 1,
            'requests_id' => 1,
            'storage_ubications_id' => 1,
            'created' => '2016-08-04 16:12:48',
            'modified' => '2016-08-04 16:12:48'
        ],
    ];
}
