<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoggingFixture
 *
 */
class LoggingFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'logging';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'users_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'register' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'logging_sections_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'logging_actions_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_logging_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
            'fk_logging_logging_sections1_idx' => ['type' => 'index', 'columns' => ['logging_sections_id'], 'length' => []],
            'fk_logging_logging_actions1_idx' => ['type' => 'index', 'columns' => ['logging_actions_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_logging_logging_actions1' => ['type' => 'foreign', 'columns' => ['logging_actions_id'], 'references' => ['logging_actions', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_logging_logging_sections1' => ['type' => 'foreign', 'columns' => ['logging_sections_id'], 'references' => ['logging_sections', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_logging_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'register' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'logging_sections_id' => 1,
            'created' => '2016-06-15 08:26:34',
            'logging_actions_id' => 1
        ],
    ];
}
