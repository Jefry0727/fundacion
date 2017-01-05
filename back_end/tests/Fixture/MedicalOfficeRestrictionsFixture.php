<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MedicalOfficeRestrictionsFixture
 *
 */
class MedicalOfficeRestrictionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'description' => ['type' => 'string', 'length' => 80, 'null' => true, 'default' => null, 'comment' => '	', 'precision' => null, 'fixed' => null],
        'date_ini' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '	', 'precision' => null],
        'date_end' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'medical_offices_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_schedule_intervals_restrictions_medical_offices1_idx' => ['type' => 'index', 'columns' => ['medical_offices_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_schedule_intervals_restrictions_medical_offices1' => ['type' => 'foreign', 'columns' => ['medical_offices_id'], 'references' => ['medical_offices', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'description' => 'Lorem ipsum dolor sit amet',
            'date_ini' => '2016-06-22 10:00:57',
            'date_end' => '2016-06-22 10:00:57',
            'medical_offices_id' => 1
        ],
    ];
}
