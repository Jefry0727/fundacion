<?php
namespace App\Model\Table;

use App\Model\Entity\Payment;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Payments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $FormPayments
 * @property \Cake\ORM\Association\BelongsTo $BillTypes
 * @property \Cake\ORM\Association\BelongsTo $Bills
 * @property \Cake\ORM\Association\BelongsTo $PaymentType
 */
class PaymentsTable extends Table
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

        $this->table('payments');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FormPayments', [
            'foreignKey' => 'form_payments_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('BillTypes', [
            'foreignKey' => 'bill_types_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Bills', [
            'foreignKey' => 'bills_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PaymentType', [
            'foreignKey' => 'payment_type_id',
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
            ->allowEmpty('credit_card_number');

        $validator
            ->decimal('debit')
            ->requirePresence('debit', 'create')
            ->notEmpty('debit');

        $validator
            ->decimal('credit')
            ->requirePresence('credit', 'create')
            ->notEmpty('credit');

        $validator
            ->decimal('donation')
            ->requirePresence('donation', 'create')
            ->notEmpty('donation');

        $validator
            ->decimal('discount')
            ->requirePresence('discount', 'create')
            ->notEmpty('discount');

        $validator
            ->decimal('copayment')
            ->requirePresence('copayment', 'create')
            ->notEmpty('copayment');

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
        $rules->add($rules->existsIn(['users_id'], 'Users'));
        $rules->add($rules->existsIn(['form_payments_id'], 'FormPayments'));
        $rules->add($rules->existsIn(['bill_types_id'], 'BillTypes'));
        $rules->add($rules->existsIn(['bills_id'], 'Bills'));
        $rules->add($rules->existsIn(['payment_type_id'], 'PaymentType'));
        return $rules;
    }
}
