<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LendPlate Entity.
 *
 * @property int $id
 * @property string $observations
 * @property \App\Model\Entity\Delivered $delivered
 * @property string $phone
 * @property int $returned
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $return_date
 * @property int $attentions_id
 * @property \App\Model\Entity\Attention $attention
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 * @property string $direction
 * @property string $document
 */
class LendPlate extends Entity
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
