<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity.
 *
 * @property int $id
 * @property string $order_consec
 * @property string $validator
 * @property string $calculated_age
 * @property string $observations
 * @property float $subtotal
 * @property float $discount
 * @property float $donation
 * @property float $total
 * @property float $total_cancel
 * @property float $copayment
 * @property int $discount_type
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
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
 * @property int $centers_id
 * @property \App\Model\Entity\Center $center
 * @property int $order_states_id
 * @property \App\Model\Entity\OrderState $order_state
 * @property int $cie_ten_codes_id
 * @property \App\Model\Entity\CieTenCode $cie_ten_code
 * @property int $consultation_endings_id
 * @property \App\Model\Entity\ConsultationEnding $consultation_ending
 * @property int $external_causes_id
 * @property \App\Model\Entity\ExternalCause $external_cause
 * @property int $cost_centers_id
 * @property \App\Model\Entity\CostCenter $cost_center
 * @property int $bill_types_id
 * @property \App\Model\Entity\Appointment[] $appointments
 * @property \App\Model\Entity\Bill[] $bills
 * @property \App\Model\Entity\Payment[] $payments
 */
class Order extends Entity
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
