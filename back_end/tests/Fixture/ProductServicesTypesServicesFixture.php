<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductServicesTypesServicesFixture
 *
 */
class ProductServicesTypesServicesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'services_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'product_services_types_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_product_services_types_services_services1_idx' => ['type' => 'index', 'columns' => ['services_id'], 'length' => []],
            'fk_product_services_types_services_product_services_types1_idx' => ['type' => 'index', 'columns' => ['product_services_types_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_product_services_types_services_product_services_types1' => ['type' => 'foreign', 'columns' => ['product_services_types_id'], 'references' => ['product_services_types', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_product_services_types_services_services1' => ['type' => 'foreign', 'columns' => ['services_id'], 'references' => ['services', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
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
            'services_id' => 1,
            'product_services_types_id' => 1
        ],
    ];
}
