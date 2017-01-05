<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BuyOrderDetail Entity.
 *
 * @property int $id
 * @property int $buy_orders_id
 * @property \App\Model\Entity\BuyOrder $buy_order
 * @property int $products_id
 * @property \App\Model\Entity\Product $product
 * @property int $quantity
 * @property float $subtotal
 * @property float $individual_value
 * @property float $iva
 * @property float $total
 */
class BuyOrderDetail extends Entity
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
