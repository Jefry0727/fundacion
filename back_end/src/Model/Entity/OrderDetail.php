<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderDetail Entity.
 *
 * @property int $id
 * @property float $subtotal
 * @property string $validator
 * @property float $total
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $observations
 * @property string $calculated_age
 * @property float $discount
 * @property int $discount_type
 * @property int $clients_id
 * @property \App\Model\Entity\Client $client
 * @property int $rates_id
 * @property \App\Model\Entity\Rate $rate
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 * @property int $patients_id
 * @property \App\Model\Entity\Patient $patient
 * @property int $external_specialists_id
 * @property \App\Model\Entity\ExternalSpecialist $external_specialist
 * @property int $service_type_id
 * @property \App\Model\Entity\ServiceType $service_type
 * @property int $order_types_id
 * @property \App\Model\Entity\OrderType $order_type
 * @property int $centers_id
 * @property \App\Model\Entity\Center $center
 * @property \App\Model\Entity\FormPayment $form_payment
 * @property \App\Model\Entity\BillType $bill_type
 * @property \App\Model\Entity\Order[] $orders
 */
class OrderDetail extends Entity
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
