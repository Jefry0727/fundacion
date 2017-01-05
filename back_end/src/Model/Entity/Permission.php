<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Permission Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $permission_identifier
 * @property string $description
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $parent_permission_id
 * @property \App\Model\Entity\ParentPermission $parent_permission
 * @property \App\Model\Entity\Role[] $roles
 */
class Permission extends Entity
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
