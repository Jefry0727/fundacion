<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Specialist Entity.
 *
 * @property int $id
 * @property int $people_id
 * @property \App\Model\Entity\Person $person
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $signature
 * @property string $professionar_card
 * @property string $speciality
 * @property \App\Model\Entity\Study[] $studies
 * @property \App\Model\Entity\ScheduleSpecialist[] $schedule_specialists
 */
class Specialist extends Entity
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
