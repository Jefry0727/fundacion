<?php
namespace App\Model\Table;

use App\Model\Entity\TransferDetail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TransferDetails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Transfers
 * @property \Cake\ORM\Association\BelongsTo $StorageUbications
 * @property \Cake\ORM\Association\BelongsTo $ProductDetails
 * @property \Cake\ORM\Association\BelongsTo $StorageInputs
 */
class TransferDetailsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('transfer_details');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Transfers', [
            'foreignKey' => 'transfers_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('StorageUbications', [
            'foreignKey' => 'storage_ubications_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ProductDetails', [
            'foreignKey' => 'product_details_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('StorageInputs', [
            'foreignKey' => 'storage_inputs_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('state')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->integer('output_code')
            ->allowEmpty('output_code');

        $validator
            ->integer('quant_output')
            ->allowEmpty('quant_output');

        $validator
            ->allowEmpty('value');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['transfers_id'], 'Transfers'));
        $rules->add($rules->existsIn(['storage_ubications_id'], 'StorageUbications'));
        $rules->add($rules->existsIn(['product_details_id'], 'ProductDetails'));
        $rules->add($rules->existsIn(['storage_inputs_id'], 'StorageInputs'));
        return $rules;
    }
}
