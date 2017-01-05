<?php
namespace App\Model\Table;

use App\Model\Entity\BillDetail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillDetails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Bills
 */
class BillDetailsTable extends Table
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

        $this->table('bill_details');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Bills', [
            'foreignKey' => 'bills_id',
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
            ->requirePresence('bill_resolutions', 'create')
            ->notEmpty('bill_resolutions');

        $validator
            ->integer('type')
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->allowEmpty('people_identification');

        $validator
            ->allowEmpty('people_full_name');

        $validator
            ->allowEmpty('people_address');

        $validator
            ->allowEmpty('client_name');

        $validator
            ->allowEmpty('rate_name');

        $validator
            ->date('bill_created')
            ->allowEmpty('bill_created');

        $validator
            ->date('bill_expiration')
            ->allowEmpty('bill_expiration');

        $validator
            ->allowEmpty('order_center');

        $validator
            ->allowEmpty('order_cost_center');

        $validator
            ->allowEmpty('order_consec');

        $validator
            ->allowEmpty('regimes_name');

        $validator
            ->allowEmpty('people_age');

        $validator
            ->allowEmpty('order_validator');

        $validator
            ->allowEmpty('client_nit');

        $validator
            ->allowEmpty('people_phone');

        $validator
            ->allowEmpty('city');

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
        $rules->add($rules->existsIn(['bills_id'], 'Bills'));
        return $rules;
    }
}
