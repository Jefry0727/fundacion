<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RipProcedimiento Entity.
 *
 * @property int $id
 * @property string $num_factura
 * @property string $cod_ips
 * @property string $tip_identificacion
 * @property string $identificacion
 * @property \Cake\I18n\Time $fec_procedimiento
 * @property string $num_autorizacion
 * @property string $cod_procedimiento
 * @property string $ambito
 * @property string $finalidad
 * @property string $persona_atiende
 * @property string $dx_prin
 * @property string $dx_relacionado
 * @property string $complicacion
 * @property string $forma
 * @property float $precio
 * @property string $entidad
 * @property int $state
 */
class RipProcedimiento extends Entity
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
