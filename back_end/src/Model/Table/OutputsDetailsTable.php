<?php
namespace App\Model\Table;

use App\Model\Entity\OutputsDetail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OutputsDetails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Outputs
 * @property \Cake\ORM\Association\BelongsTo $StorageInputs
 */
class OutputsDetailsTable extends Table
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

        $this->table('outputs_details');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Outputs', [
            'foreignKey' => 'outputs_id',
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
            ->integer('output_code')
            ->allowEmpty('output_code');

        $validator
            ->integer('quant_output')
            ->allowEmpty('quant_output');

        $validator
            ->integer('value')
            ->allowEmpty('value');

        $validator
            ->integer('state')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

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
        $rules->add($rules->existsIn(['outputs_id'], 'Outputs'));
        $rules->add($rules->existsIn(['storage_inputs_id'], 'StorageInputs'));
        return $rules;
    }
}
