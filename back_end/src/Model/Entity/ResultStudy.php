<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResultStudy Entity.
 *
 * @property int $id
 * @property int $attentions_id
 * @property \App\Model\Entity\Attention $attention
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $content
 * @property int $specialists_id
 * @property \App\Model\Entity\Specialist $specialist
 */
class ResultStudy extends Entity
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
