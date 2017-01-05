<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Client Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $nit
 * @property string $social_reazon
 * @property string $ars_code
 * @property string $address
 * @property string $responsible
 * @property string $email
 * @property string $phone
 * @property string $phone2
 * @property int $state
 * @property int $municipalities_id
 * @property \App\Model\Entity\Municipality $municipality
 * @property string $ciiu
 * @property int $types_client_id
 * @property \App\Model\Entity\Rate[] $rates
 * @property \App\Model\Entity\ClientContact[] $client_contacts
 */
class Client extends Entity
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
