<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductDetail Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $expiration_date
 * @property string $lot
 * @property string $temp_store
 * @property string $order_code
 * @property int $products_id
 * @property \App\Model\Entity\Product $product
 * @property int $marks_id
 * @property \App\Model\Entity\Mark $mark
 * @property int $units_id
 * @property \App\Model\Entity\Unit $unit
 * @property int $invima_codes_id
 * @property \App\Model\Entity\InvimaCode $invima_code
 * @property int $total
 * @property \App\Model\Entity\Provider $provider
 */
class ProductDetail extends Entity
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
