<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CardiologyErgometry Entity.
 *
 * @property int $id
 * @property int $control_formats_id
 * @property \App\Model\Entity\ControlFormat $control_format
 * @property string $format_consec
 * @property int $rejected_study
 * @property string $rejected_study_cause
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $users_id
 */
class CardiologyErgometry extends Entity
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
