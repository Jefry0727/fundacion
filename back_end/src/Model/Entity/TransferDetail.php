<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TransferDetail Entity.
 *
 * @property int $id
 * @property int $state
 * @property int $output_code
 * @property int $quant_output
 * @property int $transfers_id
 * @property \App\Model\Entity\Transfer $transfer
 * @property int $value
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $storage_ubications_id
 * @property \App\Model\Entity\StorageUbication $storage_ubication
 * @property int $product_details_id
 * @property \App\Model\Entity\ProductDetail $product_detail
 * @property int $storage_inputs_id
 * @property \App\Model\Entity\StorageInput $storage_input
 */
class TransferDetail extends Entity
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
