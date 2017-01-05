<?php
namespace App\Model\Table;

use App\Model\Entity\PaymentAccountsBill;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PaymentAccountsBills Model
 *
 * @property \Cake\ORM\Association\BelongsTo $PaymentAccounts
 * @property \Cake\ORM\Association\BelongsTo $Bills
 */
class PaymentAccountsBillsTable extends Table
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

        $this->table('payment_accounts_bills');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('PaymentAccounts', [
            'foreignKey' => 'payment_accounts_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['payment_accounts_id'], 'PaymentAccounts'));
        $rules->add($rules->existsIn(['bills_id'], 'Bills'));
        return $rules;
    }
}
