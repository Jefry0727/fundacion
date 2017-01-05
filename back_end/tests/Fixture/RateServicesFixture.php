<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RateServicesFixture
 *
 */
class RateServicesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'value' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'date_end' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'end date', 'precision' => null],
        'date_ini' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'initial date', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'state' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '1 : activo, 0 inactivo', 'precision' => null, 'autoIncrement' => null],
        'rates_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'servicises_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_rate_service_rates1_idx' => ['type' => 'index', 'columns' => ['rates_id'], 'length' => []],
            'fk_rate_service_servicises1_idx' => ['type' => 'index', 'columns' => ['servicises_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_rate_service_rates1' => ['type' => 'foreign', 'columns' => ['rates_id'], 'references' => ['rates', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_rate_service_servicises1' => ['type' => 'foreign', 'columns' => ['servicises_id'], 'references' => ['services', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'value' => 1.5,
            'date_end' => '2016-10-24 17:06:13',
            'date_ini' => '2016-10-24 17:06:13',
            'created' => '2016-10-24 17:06:13',
            'modified' => '2016-10-24 17:06:13',
            'state' => 1,
            'rates_id' => 1,
            'servicises_id' => 1
        ],
    ];
}
