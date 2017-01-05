<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillResolution Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $date_expeditions
 * @property \Cake\I18n\Time $date_expiration
 * @property int $resolution_concepts_id
 * @property \App\Model\Entity\ResolutionConcept $resolution_concept
 * @property string $resolution
 * @property string $prefix
 * @property int $ini
 * @property int $end
 * @property int $current_number
 * @property int $center_id
 * @property \App\Model\Entity\Center $center
 * @property int $bill_types_id
 * @property \App\Model\Entity\BillType $bill_type
 */
class BillResolution extends Entity
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
