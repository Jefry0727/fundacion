<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transaction Entity.
 *
 * @property int $id
 * @property int $transfers_id
 * @property \App\Model\Entity\Transfer $transfer
 * @property int $inputs_id
 * @property \App\Model\Entity\Input $input
 * @property int $outputs_id
 * @property \App\Model\Entity\Output $output
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Transaction extends Entity
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
