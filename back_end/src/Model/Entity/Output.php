<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Output Entity.
 *
 * @property int $id
 * @property string $request_code
 * @property string $observation
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $outputs
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 * @property int $state
 * @property int $cost_centers_id
 */
class Output extends Entity
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
