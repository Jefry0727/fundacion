<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RateStudiesFixture
 *
 */
class RateStudiesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'studies_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'rates_clients_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'value' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'date_ini' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'initial date', 'precision' => null],
        'date_end' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'end date', 'precision' => null],
        '_indexes' => [
            'fk_rates_has_studies_studies1_idx' => ['type' => 'index', 'columns' => ['studies_id'], 'length' => []],
            'fk_rate_studies_rates_clients1_idx' => ['type' => 'index', 'columns' => ['rates_clients_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_rate_studies_rates_clients1' => ['type' => 'foreign', 'columns' => ['rates_clients_id'], 'references' => ['rates_clients', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_rates_has_studies_studies1' => ['type' => 'foreign', 'columns' => ['studies_id'], 'references' => ['studies', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'studies_id' => 1,
            'rates_clients_id' => 1,
            'value' => 1.5,
            'date_ini' => '2016-06-24 09:03:02',
            'date_end' => '2016-06-24 09:03:02'
        ],
    ];
}
