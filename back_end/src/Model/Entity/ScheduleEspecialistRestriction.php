<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ScheduleEspecialistRestriction Entity.
 *
 * @property int $Id
 * @property string $description
 * @property \Cake\I18n\Time $date_ini
 * @property \Cake\I18n\Time $date_end
 * @property int $specialists_id
 * @property \App\Model\Entity\Specialist $specialist
 */
class ScheduleEspecialistRestriction extends Entity
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
        'Id' => false,
    ];
}
