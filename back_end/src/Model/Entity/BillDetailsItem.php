<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillDetailsItem Entity.
 *
 * @property int $id
 * @property int $item_id
 * @property \App\Model\Entity\Item $item
 * @property float $value
 * @property int $quantity
 * @property int $bill_details_a_id
 * @property \App\Model\Entity\BillDetail $bill_detail
 * @property int $item_types_id
 * @property \App\Model\Entity\ItemType $item_type
 * @property \Cake\I18n\Time $created
 */
class BillDetailsItem extends Entity
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
