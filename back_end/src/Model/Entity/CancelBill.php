<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CancelBill Entity.
 *
 * @property int $id
 * @property int $bills_id
 * @property \App\Model\Entity\Bill $bill
 * @property string $bill_number
 * @property string $reazons
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 */
class CancelBill extends Entity
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
