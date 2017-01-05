<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RipUsuario Entity.
 *
 * @property int $id
 * @property string $tipo
 * @property string $identificacion
 * @property string $cod_ars
 * @property string $tipo_usuario
 * @property string $apellido1
 * @property string $apellido2
 * @property string $nombre1
 * @property string $nombre2
 * @property string $edad
 * @property string $edad_unidad
 * @property string $sexo
 * @property string $cod_depto
 * @property string $cod_municipio
 * @property string $zona
 * @property \Cake\I18n\Time $fecha
 * @property string $entidad
 * @property int $state
 * @property string $orderConsectuiva
 * @property string $clientName
 * @property string $ratesName
 * @property int $stateClient
 * @property int $stateRates
 * @property int $idrRatesClient
 */
class RipUsuario extends Entity
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
