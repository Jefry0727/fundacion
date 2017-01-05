<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RipMedicamento Entity.
 *
 * @property int $id
 * @property string $num_factura
 * @property string $cod_ips
 * @property string $document_type
 * @property string $identificacion
 * @property string $num_autorizacion
 * @property string $cod_medicamento
 * @property string $tipo_medicamento
 * @property string $nombre_gen
 * @property string $form_farmaceutica
 * @property string $concentracion
 * @property string $unidad_medida
 * @property string $cantidad
 * @property string $val_unitario
 * @property string $val_total
 * @property \Cake\I18n\Time $date
 * @property int $clients_id
 * @property \App\Model\Entity\Client $client
 * @property int $rates_id
 */
class RipMedicamento extends Entity
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
