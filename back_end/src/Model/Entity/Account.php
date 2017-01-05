<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Account Entity.
 *
 * @property int $id
 * @property int $account_documents_id
 * @property \App\Model\Entity\AccountDocument $account_document
 * @property int $cost_centers_id
 * @property \App\Model\Entity\CostCenter $cost_center
 * @property int $auxiliar
 * @property string $description
 * @property float $debit_pcga
 * @property float $credit_pcga
 * @property string $nit
 * @property string $social_reazon
 * @property float $debit_altern_pcga
 * @property float $credit_altern_pcga
 * @property string $cpto_cash_flow
 * @property string $desc_cpto_cash_flow
 * @property string $notes
 * @property float $base_gravable_pcga
 * @property string $docto_banc
 * @property float $debit_niif
 * @property float $credit_niif
 * @property float $debit_altern_niif
 * @property float $credit_altern_niif
 * @property float $base_gravable_niif
 * @property float $debit_ajust
 * @property float $credit_ajust
 * @property float $debit_altern_ajust
 * @property float $credit_altern_ajust
 * @property float $base_gravable_ajust
 * @property int $state
 * @property int $send_interfaz
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $date_send
 * @property int $users_id
 * @property \App\Model\Entity\User $user
 * @property int $entitys_id
 */
class Account extends Entity
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
