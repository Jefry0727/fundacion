<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SpecialistRoleFixture
 *
 */
class SpecialistRoleFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'specialist_role';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'specialists_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'specializations_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_specilist_role_specialists1_idx' => ['type' => 'index', 'columns' => ['specialists_id'], 'length' => []],
            'fk_specilist_role_specializations1_idx' => ['type' => 'index', 'columns' => ['specializations_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_specilist_role_specialists1' => ['type' => 'foreign', 'columns' => ['specialists_id'], 'references' => ['specialists', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_specilist_role_specializations1' => ['type' => 'foreign', 'columns' => ['specializations_id'], 'references' => ['specializations', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'specialists_id' => 1,
            'specializations_id' => 1
        ],
    ];
}
