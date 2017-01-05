<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ClientBusinessFixture
 *
 */
class ClientBusinessFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'client_business';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'observation' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'capital' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'clients_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'business_terms_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'type' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '1.per capita, 2 bolsa', 'precision' => null, 'autoIncrement' => null],
        'date_end' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_client_business_clients1_idx' => ['type' => 'index', 'columns' => ['clients_id'], 'length' => []],
            'fk_client_business_business_terms1_idx' => ['type' => 'index', 'columns' => ['business_terms_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_client_business_business_terms1' => ['type' => 'foreign', 'columns' => ['business_terms_id'], 'references' => ['business_terms', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_client_business_clients1' => ['type' => 'foreign', 'columns' => ['clients_id'], 'references' => ['clients', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'observation' => 'Lorem ipsum dolor sit amet',
            'capital' => 1.5,
            'clients_id' => 1,
            'business_terms_id' => 1,
            'type' => 1,
            'date_end' => '2016-07-08 11:35:58',
            'created' => '2016-07-08 11:35:58',
            'modified' => '2016-07-08 11:35:58'
        ],
    ];
}
