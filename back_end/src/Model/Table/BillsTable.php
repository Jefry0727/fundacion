<?php
namespace App\Model\Table;

use App\Model\Entity\Bill;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bills Model
 *
 * @property \Cake\ORM\Association\BelongsTo $BillResolutions
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsToMany $Orders
 */
class BillsTable extends Table
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

        $this->table('bills');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('BillResolutions', [
            'foreignKey' => 'bill_resolutions_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Orders', [
            'foreignKey' => 'bills_id',
            'targetForeignKey' => 'orders_id',
            'joinTable' => 'orders_bills'
        ]);
        $this->hasMany('Payments',[
            'foreignKey' => 'bills_id'
        ]);
        $this->hasMany('BillDetails',[
            'foreignKey' => 'bills_id'
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
            ->notEmpty('bill_number')
            ->add('bill_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('canceled')
            ->requirePresence('canceled', 'create')
            ->notEmpty('canceled');

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
        $rules->add($rules->isUnique(['bill_number']));
        $rules->add($rules->existsIn(['bill_resolutions_id'], 'BillResolutions'));
        $rules->add($rules->existsIn(['users_id'], 'Users'));
        return $rules;
    }
}
