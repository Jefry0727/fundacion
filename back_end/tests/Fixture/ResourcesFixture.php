<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResourcesFixture
 *
 */
class ResourcesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'users_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'stored_file_name' => ['type' => 'string', 'length' => 150, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '	', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'entity_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'identificador de la entidad a la que pertenece', 'precision' => null, 'autoIncrement' => null],
        'resource_extensions_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'resource_types_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'resource_parent_entities_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'bytes' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'size_format' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'fk_rosources_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
            'fk_rosources_resource_extensions1_idx' => ['type' => 'index', 'columns' => ['resource_extensions_id'], 'length' => []],
            'fk_resources_resource_types1_idx' => ['type' => 'index', 'columns' => ['resource_types_id'], 'length' => []],
            'fk_resources_resource_parent_entities1_idx' => ['type' => 'index', 'columns' => ['resource_parent_entities_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_resources_resource_parent_entities1' => ['type' => 'foreign', 'columns' => ['resource_parent_entities_id'], 'references' => ['resource_parent_entities', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_resources_resource_types1' => ['type' => 'foreign', 'columns' => ['resource_types_id'], 'references' => ['resource_types', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_rosources_resource_extensions1' => ['type' => 'foreign', 'columns' => ['resource_extensions_id'], 'references' => ['resource_extensions', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'fk_rosources_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
            'users_id' => 1,
            'stored_file_name' => 'Lorem ipsum dolor sit amet',
            'name' => 'Lorem ipsum dolor sit amet',
            'created' => '2016-12-26 10:43:28',
            'modified' => '2016-12-26 10:43:28',
            'entity_id' => 1,
            'resource_extensions_id' => 1,
            'resource_types_id' => 1,
            'resource_parent_entities_id' => 1,
            'bytes' => 'Lorem ipsum dolor sit amet',
            'size_format' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
