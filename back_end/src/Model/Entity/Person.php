<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Person Entity.
 *
 * @property int $id
 * @property int $document_types_id
 * @property \App\Model\Entity\DocumentType $document_type
 * @property string $identification
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $last_name_two
 * @property \Cake\I18n\Time $birthdate
 * @property int $gender
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $municipalities_id
 * @property \App\Model\Entity\Municipality $municipality
 * @property int $user_creation
 * @property \App\Model\Entity\Patient[] $patients
 * @property \App\Model\Entity\User[] $users
 */
class Person extends Entity
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
