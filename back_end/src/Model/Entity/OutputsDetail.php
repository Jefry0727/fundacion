<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OutputsDetail Entity.
 *
 * @property int $id
 * @property int $output_code
 * @property int $quant_output
 * @property int $value
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $outputs_id
 * @property \App\Model\Entity\Output $output
 * @property int $state
 * @property int $storage_inputs_id
 * @property \App\Model\Entity\StorageInput $storage_input
 */
class OutputsDetail extends Entity
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
