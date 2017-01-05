<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ScheduleSpecialist Entity.
 *
 * @property int $id
 * @property int $specialists_id
 * @property \App\Model\Entity\Specialist $specialist
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $day
 * @property \Cake\I18n\Time $time_ini
 * @property \Cake\I18n\Time $time_end
 * @property string $description
 * @property int $schedule_specialist_types_id
 * @property \App\Model\Entity\ScheduleSpecialistType $schedule_specialist_type
 * @property int $medical_offices_id
 * @property \App\Model\Entity\MedicalOffice $medical_office
 */
class ScheduleSpecialist extends Entity
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
