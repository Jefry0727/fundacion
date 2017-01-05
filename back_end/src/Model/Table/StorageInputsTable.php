<?php
namespace App\Model\Table;

use App\Model\Entity\StorageInput;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StorageInputs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $StorageUbications
 * @property \Cake\ORM\Association\BelongsTo $ProductDetails
 */
class StorageInputsTable extends Table
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

        $this->table('storage_inputs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('StorageUbications', [
            'foreignKey' => 'storage_ubications_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ProductDetails', [
            'foreignKey' => 'product_details_id',
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
            ->integer('quant_input')
            ->allowEmpty('quant_input');

        $validator
            ->integer('remaining')
            ->allowEmpty('remaining');

        $validator
            ->allowEmpty('observations');

        $validator
            ->numeric('single_value')
            ->allowEmpty('single_value');

        $validator
            ->numeric('value')
            ->allowEmpty('value');

        $validator
            ->allowEmpty('bill_code');

        $validator
            ->integer('state')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->date('inputDate')
            ->allowEmpty('inputDate');

        $validator
            ->numeric('iva')
            ->requirePresence('iva', 'create')
            ->notEmpty('iva');

        $validator
            ->numeric('subtotal_value')
            ->requirePresence('subtotal_value', 'create')
            ->notEmpty('subtotal_value');

        $validator
            ->numeric('discount')
            ->requirePresence('discount', 'create')
            ->notEmpty('discount');

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
        $rules->add($rules->existsIn(['storage_ubications_id'], 'StorageUbications'));
        $rules->add($rules->existsIn(['product_details_id'], 'ProductDetails'));
        return $rules;
    }
}
