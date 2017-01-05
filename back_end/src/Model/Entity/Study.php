<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Study Entity.
 *
 * @property int $id
 * @property string $cup
 * @property string $name
 * @property int $specializations_id
 * @property \App\Model\Entity\Specialization $specialization
 * @property int $average_time
 * @property string $type
 * @property int $format_types_id
 * @property \App\Model\Entity\FormatType $format_type
 * @property string $coments
 * @property float $radiation_dose
 * @property \App\Model\Entity\Product[] $products
 * @property \App\Model\Entity\InformedConsent[] $informed_consents
 * @property \App\Model\Entity\MedicalOffice[] $medical_offices
 * @property \App\Model\Entity\Specialist[] $specialists
 * @property \App\Model\Entity\ServiceType $service_type
 * @property \App\Model\Entity\Product[] $products
 * @property \App\Model\Entity\Instructive[] $instructives
 * @property \App\Model\Entity\StudiesInformedConsent[] $studies_informed_consents
 */
class Study extends Entity
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
