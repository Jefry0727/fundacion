<?php
namespace App\Model\Table;

use App\Model\Entity\ManualBill;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ManualBills Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Entities
 * @property \Cake\ORM\Association\BelongsTo $BillTypes
 * @property \Cake\ORM\Association\BelongsTo $FormPayments
 * @property \Cake\ORM\Association\BelongsTo $Bills
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsToMany $Products
 */
class ManualBillsTable extends Table
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

        $this->table('manual_bills');
        $this->displayField('id');
        $this->primaryKey('id');

       
        $this->belongsTo('BillTypes', [
            'foreignKey' => 'bill_types_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FormPayments', [
            'foreignKey' => 'form_payments_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Bills', [
            'foreignKey' => 'bills_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'manual_bill_id',
            'targetForeignKey' => 'product_id',
            'joinTable' => 'manual_bills_products'
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
            ->requirePresence('bill_number', 'create')
            ->notEmpty('bill_number');

        $validator
            ->allowEmpty('observations');

        $validator
            ->decimal('subtotal')
            ->allowEmpty('subtotal');

        $validator
            ->decimal('discount')
            ->allowEmpty('discount');

        $validator
            ->decimal('donation')
            ->allowEmpty('donation');

        $validator
            ->decimal('total')
            ->allowEmpty('total');

        $validator
            ->decimal('total_cancel')
            ->allowEmpty('total_cancel');

        $validator
            ->allowEmpty('credit_card_number');

        $validator
            ->integer('entity_type')
            ->requirePresence('entity_type', 'create')
            ->notEmpty('entity_type');

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
       
        $rules->add($rules->existsIn(['bill_types_id'], 'BillTypes'));
        $rules->add($rules->existsIn(['form_payments_id'], 'FormPayments'));
        $rules->add($rules->existsIn(['bills_id'], 'Bills'));
        $rules->add($rules->existsIn(['users_id'], 'Users'));
        return $rules;
    }
}
