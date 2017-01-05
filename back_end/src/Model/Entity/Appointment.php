<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Appointment Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $medical_offices_id
 * @property \App\Model\Entity\MedicalOffice $medical_office
 * @property float $studies_value
 * @property int $studies_id
 * @property \App\Model\Entity\Study $study
 * @property int $type
 * @property string $observations
 * @property \Cake\I18n\Time $expected_date
 * @property \App\Model\Entity\Attention[] $attentions
 * @property \App\Model\Entity\AppointmentDate[] $appointment_dates
 * @property \App\Model\Entity\Order[] $orders
 */
class Appointment extends Entity
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
