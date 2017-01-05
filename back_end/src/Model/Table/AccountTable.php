<?php
namespace App\Model\Table;

use App\Model\Entity\Account;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Account Model
 *
 * @property \Cake\ORM\Association\BelongsTo $AccountDocuments
 * @property \Cake\ORM\Association\BelongsTo $CostCenters
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Entitys
 */
class AccountTable extends Table
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

        $this->table('account');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('AccountDocuments', [
            'foreignKey' => 'account_documents_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CostCenters', [
            'foreignKey' => 'cost_centers_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
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
            ->integer('auxiliar')
            ->allowEmpty('auxiliar');

        $validator
            ->allowEmpty('description');

        $validator
            ->numeric('debit_pcga')
            ->allowEmpty('debit_pcga');

        $validator
            ->numeric('credit_pcga')
            ->allowEmpty('credit_pcga');

        $validator
            ->requirePresence('nit', 'create')
            ->notEmpty('nit');

        $validator
            ->allowEmpty('social_reazon');

        $validator
            ->numeric('debit_altern_pcga')
            ->allowEmpty('debit_altern_pcga');

        $validator
            ->numeric('credit_altern_pcga')
            ->allowEmpty('credit_altern_pcga');

        $validator
            ->allowEmpty('cpto_cash_flow');

        $validator
            ->allowEmpty('desc_cpto_cash_flow');

        $validator
            ->allowEmpty('notes');

        $validator
            ->numeric('base_gravable_pcga')
            ->allowEmpty('base_gravable_pcga');

        $validator
            ->allowEmpty('docto_banc');

        $validator
            ->numeric('debit_niif')
            ->requirePresence('debit_niif', 'create')
            ->notEmpty('debit_niif');

        $validator
            ->numeric('credit_niif')
            ->requirePresence('credit_niif', 'create')
            ->notEmpty('credit_niif');

        $validator
            ->numeric('debit_altern_niif')
            ->requirePresence('debit_altern_niif', 'create')
            ->notEmpty('debit_altern_niif');

        $validator
            ->numeric('credit_altern_niif')
            ->requirePresence('credit_altern_niif', 'create')
            ->notEmpty('credit_altern_niif');

        $validator
            ->numeric('base_gravable_niif')
            ->requirePresence('base_gravable_niif', 'create')
            ->notEmpty('base_gravable_niif');

        $validator
            ->numeric('debit_ajust')
            ->requirePresence('debit_ajust', 'create')
            ->notEmpty('debit_ajust');

        $validator
            ->numeric('credit_ajust')
            ->requirePresence('credit_ajust', 'create')
            ->notEmpty('credit_ajust');

        $validator
            ->numeric('debit_altern_ajust')
            ->requirePresence('debit_altern_ajust', 'create')
            ->notEmpty('debit_altern_ajust');

        $validator
            ->numeric('credit_altern_ajust')
            ->requirePresence('credit_altern_ajust', 'create')
            ->notEmpty('credit_altern_ajust');

        $validator
            ->numeric('base_gravable_ajust')
            ->requirePresence('base_gravable_ajust', 'create')
            ->notEmpty('base_gravable_ajust');

        $validator
            ->integer('state')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->integer('send_interfaz')
            ->notEmpty('send_interfaz');

        $validator
            ->dateTime('date_send')
            ->allowEmpty('date_send');

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
        $rules->add($rules->existsIn(['account_documents_id'], 'AccountDocuments'));
        $rules->add($rules->existsIn(['cost_centers_id'], 'CostCenters'));
        $rules->add($rules->existsIn(['users_id'], 'Users'));
        return $rules;
    }
}
