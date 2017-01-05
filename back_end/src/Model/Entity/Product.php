<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity.
 *
 * @property int $id
 * @property string $cup
 * @property string $name
 * @property float $value
 * @property int $section_id
 * @property \App\Model\Entity\Section $section
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $state
 * @property int $farmaseutic_form_id
 * @property string $active_principle
 * @property \App\Model\Entity\Study[] $studies
 * @property \App\Model\Entity\InvimaCode[] $invima_codes
 * @property \App\Model\Entity\ProductsDetail[] $products_details
 */
class Product extends Entity
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
