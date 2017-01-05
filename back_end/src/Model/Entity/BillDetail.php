<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillDetail Entity.
 *
 * @property int $id
 * @property string $bill_resolutions
 * @property int $bills_id
 * @property \App\Model\Entity\Bill $bill
 * @property int $type
 * @property string $people_identification
 * @property string $people_full_name
 * @property string $people_address
 * @property string $client_name
 * @property string $rate_name
 * @property \Cake\I18n\Time $bill_created
 * @property \Cake\I18n\Time $bill_expiration
 * @property string $order_center
 * @property string $order_cost_center
 * @property string $order_consec
 * @property string $regimes_name
 * @property string $people_age
 * @property string $order_validator
 * @property string $client_nit
 * @property string $people_phone
 * @property string $city
 * @property \App\Model\Entity\BillDetailsItem[] $bill_details_items
 */
class BillDetail extends Entity
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
