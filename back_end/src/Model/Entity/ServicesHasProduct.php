<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ServicesHasProduct Entity.
 *
 * @property int $id
 * @property int $services_id
 * @property \App\Model\Entity\Service $service
 * @property int $products_id
 * @property \App\Model\Entity\Product $product
 */
class ServicesHasProduct extends Entity
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
        'services_id' => false,
        'products_id' => false,
    ];
}
