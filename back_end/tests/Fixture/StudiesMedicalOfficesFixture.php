<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StudiesMedicalOfficesFixture
 *
 */
class StudiesMedicalOfficesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'studies_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'medical_offices_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_studies_has_medical_offices_medical_offices1_idx' => ['type' => 'index', 'columns' => ['medical_offices_id'], 'length' => []],
            'fk_studies_has_medical_offices_studies1_idx' => ['type' => 'index', 'columns' => ['studies_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_studies_has_medical_offices_medical_offices1' => ['type' => 'foreign', 'columns' => ['medical_offices_id'], 'references' => ['medical_offices', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_studies_has_medical_offices_studies1' => ['type' => 'foreign', 'columns' => ['studies_id'], 'references' => ['studies', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'studies_id' => 1,
            'medical_offices_id' => 1,
            'id' => 1,
            'created' => '2016-06-24 16:32:31',
            'modified' => '2016-06-24 16:32:31'
        ],
    ];
}
