<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ControlFormatsFixture
 *
 */
class ControlFormatsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'format_type_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'attentions_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'patients_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'users_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'specialists_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'has_past_studies' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '0. No , 1. Si ', 'precision' => null, 'autoIncrement' => null],
        'observations' => ['type' => 'string', 'length' => 1000, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'number_studies' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_control_formats_attentions1_idx' => ['type' => 'index', 'columns' => ['attentions_id'], 'length' => []],
            'fk_control_formats_patients1_idx' => ['type' => 'index', 'columns' => ['patients_id'], 'length' => []],
            'fk_control_formats_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
            'fk_control_formats_specialists1_idx' => ['type' => 'index', 'columns' => ['specialists_id'], 'length' => []],
            'fk_control_formats_format_type1_idx' => ['type' => 'index', 'columns' => ['format_type_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_control_formats_attentions1' => ['type' => 'foreign', 'columns' => ['attentions_id'], 'references' => ['attentions', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_control_formats_format_type1' => ['type' => 'foreign', 'columns' => ['format_type_id'], 'references' => ['format_types', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_control_formats_patients1' => ['type' => 'foreign', 'columns' => ['patients_id'], 'references' => ['patients', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_control_formats_specialists1' => ['type' => 'foreign', 'columns' => ['specialists_id'], 'references' => ['specialists', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_control_formats_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'format_type_id' => 1,
            'attentions_id' => 1,
            'patients_id' => 1,
            'users_id' => 1,
            'specialists_id' => 1,
            'has_past_studies' => 1,
            'observations' => 'Lorem ipsum dolor sit amet',
            'created' => '2016-12-23 16:36:40',
            'modified' => '2016-12-23 16:36:40',
            'number_studies' => 1
        ],
    ];
}
