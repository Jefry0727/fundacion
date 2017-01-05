<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ControlFormat Entity.
 *
 * @property int $id
 * @property int $format_type_id
 * @property \App\Model\Entity\FormatType $format_type
 * @property int $attentions_id
 * @property \App\Model\Entity\Attention $attention
 * @property int $patients_id
 * @property \App\Model\Entity\Patient $patient
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 * @property int $specialists_id
 * @property \App\Model\Entity\Specialist $specialist
 * @property int $has_past_studies
 * @property string $observations
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $number_studies
 */
class ControlFormat extends Entity
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
