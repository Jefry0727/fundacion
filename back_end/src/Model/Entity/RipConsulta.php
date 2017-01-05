<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RipConsulta Entity.
 *
 * @property int $id
 * @property string $num_factura
 * @property string $cod_ips
 * @property string $identificacion
 * @property string $num_identificacion
 * @property \Cake\I18n\Time $fec_consulta
 * @property string $num_autorizacion
 * @property string $cod_consulta
 * @property string $finalidad
 * @property string $causa_externa
 * @property string $cod_dx
 * @property string $cod_dx_rel1
 * @property string $cod_dx_rel2
 * @property string $cod_dx_rel3
 * @property string $tipo_dx
 * @property string $val_consulta
 * @property string $val_copago
 * @property string $val_neto
 * @property string $entidad
 * @property int $tipoEstudio
 */
class RipConsulta extends Entity
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
