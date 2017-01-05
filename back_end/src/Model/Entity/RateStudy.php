<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RateStudy Entity.
 *
 * @property int $id
 * @property int $studies_id
 * @property \App\Model\Entity\Study $study
 * @property int $rates_clients_id
 * @property \App\Model\Entity\RatesClient $rates_client
 * @property float $value
 * @property \Cake\I18n\Time $date_ini
 * @property \Cake\I18n\Time $date_end
 */
class RateStudy extends Entity
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
