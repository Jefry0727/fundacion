<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bill Entity.
 *
 * @property int $id
 * @property string $bill_number
 * @property int $bill_resolutions_id
 * @property \App\Model\Entity\BillResolution $bill_resolution
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 * @property int $canceled
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Order[] $orders
 */
class Bill extends Entity
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
