<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BuyOrder Entity.
 *
 * @property int $id
 * @property string $quotation_identifier
 * @property float $discount
 * @property float $total
 * @property string $observations
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 * @property int $providers_id
 * @property \App\Model\Entity\Provider $provider
 * @property \Cake\I18n\Time $date
 * @property float $iva_total
 * @property \Cake\I18n\Time $delivery_time
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class BuyOrder extends Entity
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
