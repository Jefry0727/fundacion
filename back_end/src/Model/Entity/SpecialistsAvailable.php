<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SpecialistsAvailable Entity.
 *
 * @property int $id
 * @property int $day
 * @property \Cake\I18n\Time $time_ini
 * @property \Cake\I18n\Time $time_end
 * @property int $state
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $specialists_id
 * @property \App\Model\Entity\Specialist $specialist
 * @property int $service_type_id
 * @property \App\Model\Entity\ServiceType $service_type
 */
class SpecialistsAvailable extends Entity
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
