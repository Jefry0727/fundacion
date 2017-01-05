<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Mammogram Entity.
 *
 * @property int $id
 * @property string $format_consec
 * @property int $control_formats_id
 * @property \App\Model\Entity\ControlFormat $control_format
 * @property int $broken_plate
 * @property string $broken_plate_cause
 * @property int $MA
 * @property int $KV
 * @property int $number_expositions
 * @property float $radiation_dose
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 */
class Mammogram extends Entity
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
