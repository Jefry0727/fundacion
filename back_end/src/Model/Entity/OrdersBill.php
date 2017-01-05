<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdersBill Entity.
 *
 * @property int $id
 * @property int $orders_id
 * @property \App\Model\Entity\Order $order
 * @property int $bills_id
 * @property \App\Model\Entity\Bill $bill
 */
class OrdersBill extends Entity
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
