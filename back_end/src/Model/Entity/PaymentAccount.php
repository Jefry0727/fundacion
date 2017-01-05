<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PaymentAccount Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $date_ini
 * @property \Cake\I18n\Time $date_end
 * @property int $state
 * @property int $payment_consec
 * @property \Cake\I18n\Time $created
 * @property int $rates_id
 * @property \App\Model\Entity\Rate $rate
 * @property int $clients_id
 * @property \App\Model\Entity\Client $client
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Bill[] $bills
 */
class PaymentAccount extends Entity
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
