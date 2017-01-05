<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResourceEntityDirectoriesFixture
 *
 */
class ResourceEntityDirectoriesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'directory' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'resource_parent_entities_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_resource_entity_directories_resource_parent_entities1_idx' => ['type' => 'index', 'columns' => ['resource_parent_entities_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'directory_UNIQUE' => ['type' => 'unique', 'columns' => ['directory'], 'length' => []],
            'fk_resource_entity_directories_resource_parent_entities1' => ['type' => 'foreign', 'columns' => ['resource_parent_entities_id'], 'references' => ['resource_parent_entities', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'directory' => 'Lorem ipsum dolor sit amet',
            'resource_parent_entities_id' => 1
        ],
    ];
}
