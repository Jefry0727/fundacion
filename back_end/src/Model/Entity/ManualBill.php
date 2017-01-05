<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ManualBill Entity.
 *
 * @property int $id
 * @property string $bill_number
 * @property int $entity_id
 * @property int $bill_types_id
 * @property \App\Model\Entity\BillType $bill_type
 * @property string $observations
 * @property float $subtotal
 * @property float $discount
 * @property float $donation
 * @property float $total
 * @property float $total_cancel
 * @property int $form_payments_id
 * @property \App\Model\Entity\FormPayment $form_payment
 * @property int $bills_id
 * @property string $credit_card_number
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 * @property int $entity_type
 * @property \App\Model\Entity\BillResolution $bill_resolution
 * @property \App\Model\Entity\Person $person
 * @property \App\Model\Entity\Product[] $products
 */
class ManualBill extends Entity
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
