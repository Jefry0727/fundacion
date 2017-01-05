<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StudiesFixture
 *
 */
class StudiesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'cup' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 300, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'specializations_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'average_time' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'minutes', 'precision' => null, 'autoIncrement' => null],
        'type' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => 'si es consulta o otro servicio
1.para consulta 0.otro servicio', 'precision' => null, 'fixed' => null],
        'format_types_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'coments' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'radiation_dose' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        '_indexes' => [
            'fk_studies_specializations1_idx' => ['type' => 'index', 'columns' => ['specializations_id'], 'length' => []],
            'fk_studies_format_types1_idx' => ['type' => 'index', 'columns' => ['format_types_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_studies_format_types1' => ['type' => 'foreign', 'columns' => ['format_types_id'], 'references' => ['format_types', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_studies_specializations1' => ['type' => 'foreign', 'columns' => ['specializations_id'], 'references' => ['specializations', 'id'], 'update' => 'cascade', 'delete' => 'noAction', 'length' => []],
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
            'cup' => 'Lorem ipsum dolor sit amet',
            'name' => 'Lorem ipsum dolor sit amet',
            'specializations_id' => 1,
            'average_time' => 1,
            'type' => 'Lorem ipsum dolor sit amet',
            'format_types_id' => 1,
            'coments' => 'Lorem ipsum dolor sit amet',
            'radiation_dose' => 1.5
        ],
    ];
}
