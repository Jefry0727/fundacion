<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity.
 *
 * @property int $id
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 * @property string $credit_card_number
 * @property float $debit
 * @property float $credit
 * @property float $donation
 * @property float $discount
 * @property float $copayment
 * @property int $form_payments_id
 * @property \App\Model\Entity\FormPayment $form_payment
 * @property int $bill_types_id
 * @property \App\Model\Entity\BillType $bill_type
 * @property \Cake\I18n\Time $created
 * @property int $bills_id
 * @property \App\Model\Entity\Bill $bill
 * @property int $payment_type_id
 */
class Payment extends Entity
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
