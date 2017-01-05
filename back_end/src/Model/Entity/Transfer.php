<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transfer Entity.
 *
 * @property int $id
 * @property string $transfer_code
 * @property string $observations
 * @property int $state
 * @property int $requests_id
 * @property \App\Model\Entity\Request $request
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\StorageUbication $storage_ubication
 */
class Transfer extends Entity
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
