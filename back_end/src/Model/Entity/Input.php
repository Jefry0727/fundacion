<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Input Entity.
 *
 * @property int $id
 * @property int $quant_input
 * @property int $remaining
 * @property string $observations
 * @property float $single_value
 * @property int $value
 * @property string $bill_code
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $state
 * @property \Cake\I18n\Time $inputDate
 * @property int $storage_ubications_id
 * @property \App\Model\Entity\StorageUbication $storage_ubication
 * @property int $detalle_producto_id
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\Provider $provider
 * @property \App\Model\Entity\Mark $mark
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\InvimaCode $invima_code
 * @property \App\Model\Entity\Unit $unit
 */
class Input extends Entity
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
