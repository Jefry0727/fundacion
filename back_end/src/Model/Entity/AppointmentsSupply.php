<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AppointmentsSupply Entity.
 *
 * @property int $id
 * @property float $quantity
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $appointments_id
 * @property \App\Model\Entity\Appointment $appointment
 * @property int $products_studies_id
 * @property \App\Model\Entity\ProductsStudy $products_study
 * @property float $cost
 */
class AppointmentsSupply extends Entity
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
