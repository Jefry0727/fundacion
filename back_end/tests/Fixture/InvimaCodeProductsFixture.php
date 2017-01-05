<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InvimaCodeProductsFixture
 *
 */
class InvimaCodeProductsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'products_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'invima_codes_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_invima_codes_has_products_products1_idx' => ['type' => 'index', 'columns' => ['products_id'], 'length' => []],
            'fk_invima_code_products_invima_codes1_idx' => ['type' => 'index', 'columns' => ['invima_codes_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_invima_code_products_invima_codes1' => ['type' => 'foreign', 'columns' => ['invima_codes_id'], 'references' => ['invima_codes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_invima_codes_has_products_products1' => ['type' => 'foreign', 'columns' => ['products_id'], 'references' => ['products', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'products_id' => 1,
            'invima_codes_id' => 1
        ],
    ];
}
