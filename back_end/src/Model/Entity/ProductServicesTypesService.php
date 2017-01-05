<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductServicesTypesService Entity.
 *
 * @property int $id
 * @property int $services_id
 * @property \App\Model\Entity\Service $service
 * @property int $product_services_types_id
 * @property \App\Model\Entity\ProductServicesType $product_services_type
 */
class ProductServicesTypesService extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
