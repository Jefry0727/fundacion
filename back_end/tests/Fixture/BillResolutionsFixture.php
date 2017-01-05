<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillResolutionsFixture
 *
 */
class BillResolutionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'date_expeditions' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'date_expiration' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'resolution_concepts_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'resolution' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'prefix' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'ini' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'end' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'current_number' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'center_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'bill_types_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_resolutions_resolution_concepts1_idx' => ['type' => 'index', 'columns' => ['resolution_concepts_id'], 'length' => []],
            'fk_center_idx' => ['type' => 'index', 'columns' => ['center_id'], 'length' => []],
            'fk_bill_resolutions_bill_types1_idx' => ['type' => 'index', 'columns' => ['bill_types_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_bill_resolutions_bill_types1' => ['type' => 'foreign', 'columns' => ['bill_types_id'], 'references' => ['bill_types', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_resolutions_resolution_concepts1' => ['type' => 'foreign', 'columns' => ['resolution_concepts_id'], 'references' => ['resolution_concepts', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'date_expeditions' => '2016-09-23',
            'date_expiration' => '2016-09-23',
            'resolution_concepts_id' => 1,
            'resolution' => 'Lorem ipsum dolor sit amet',
            'prefix' => 'Lorem ip',
            'ini' => 1,
            'end' => 1,
            'current_number' => 1,
            'center_id' => 1,
            'bill_types_id' => 1
        ],
    ];
}
