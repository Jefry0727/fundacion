<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Nuclear Entity.
 *
 * @property int $id
 * @property int $control_formats_id
 * @property \App\Model\Entity\ControlFormat $control_format
 * @property int $broken_plate
 * @property string $broken_plate_cause
 * @property float $radiation_dose_mci
 * @property string $format_consec
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 * @property string $radiopharmaceutical
 */
class Nuclear extends Entity
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
