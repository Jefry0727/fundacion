<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RateService Entity.
 *
 * @property int $id
 * @property float $value
 * @property \Cake\I18n\Time $date_end
 * @property \Cake\I18n\Time $date_ini
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $state
 * @property int $rates_id
 * @property \App\Model\Entity\Rate $rate
 * @property int $servicises_id
 * @property \App\Model\Entity\Service $service
 */
class RateService extends Entity
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
