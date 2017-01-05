<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Resource Entity.
 *
 * @property int $id
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 * @property string $stored_file_name
 * @property string $name
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $entity_id
 * @property \App\Model\Entity\Entity $entity
 * @property int $resource_extensions_id
 * @property \App\Model\Entity\ResourceExtension $resource_extension
 * @property int $resource_types_id
 * @property \App\Model\Entity\ResourceType $resource_type
 * @property int $resource_parent_entities_id
 * @property \App\Model\Entity\ResourceParentEntity $resource_parent_entity
 * @property string $bytes
 * @property string $size_format
 */
class Resource extends Entity
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
