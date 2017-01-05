<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AttentionConsultation Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $date_time_ini
 * @property \Cake\I18n\Time $date_time_end
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $orders_id
 * @property \App\Model\Entity\Order $order
 * @property int $specialists_id
 * @property \App\Model\Entity\Specialist $specialist
 */
class AttentionConsultation extends Entity
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
