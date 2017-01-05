<?php
namespace App\Model\Table;

use App\Model\Entity\Transaction;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transactions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Transfers
 * @property \Cake\ORM\Association\BelongsTo $Inputs
 * @property \Cake\ORM\Association\BelongsTo $Outputs
 */
class TransactionsTable extends Table
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

        $this->table('transactions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Transfers', [
            'foreignKey' => 'transfers_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Inputs', [
            'foreignKey' => 'inputs_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Outputs', [
            'foreignKey' => 'outputs_id',
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
        $rules->add($rules->existsIn(['inputs_id'], 'Inputs'));
        $rules->add($rules->existsIn(['outputs_id'], 'Outputs'));
        return $rules;
    }
}
