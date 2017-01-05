<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdersAuthorization Entity.
 *
 * @property int $id
 * @property string $observations
 * @property \Cake\I18n\Time $created
 * @property int $state
 * @property int $orders_id
 * @property \App\Model\Entity\Order $order
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 */
class OrdersAuthorization extends Entity
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
