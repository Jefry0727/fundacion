<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RipDescripcion Entity.
 *
 * @property int $id
 * @property string $num_factura
 * @property string $cod_ips
 * @property string $cod_concepto
 * @property string $cantidad
 * @property string $val_unitario
 * @property string $val_concepto
 */
class RipDescripcion extends Entity
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
