<?php
namespace App\Model\Table;

use App\Model\Entity\OrderDetail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderDetails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clients
 * @property \Cake\ORM\Association\BelongsTo $Rates
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Patients
 * @property \Cake\ORM\Association\BelongsTo $ExternalSpecialists
 * @property \Cake\ORM\Association\BelongsTo $ServiceTypes
 * @property \Cake\ORM\Association\BelongsTo $OrderTypes
 * @property \Cake\ORM\Association\BelongsTo $Centers
 */
class OrderDetailsTable extends Table
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

        $this->table('order_details');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'clients_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Rates', [
            'foreignKey' => 'rates_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Patients', [
            'foreignKey' => 'patients_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ExternalSpecialists', [
            'foreignKey' => 'external_specialists_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ServiceTypes', [
            'foreignKey' => 'service_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrderTypes', [
            'foreignKey' => 'order_types_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Centers', [
            'foreignKey' => 'centers_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Orders', [
            'foreignKey' => 'order_details_id'
        ]);

         $this->belongsToMany('Appointments', [
                'foreignKey' => 'order_details_id',
                'targetForeignKey' => 'appointments_id',
                'joinTable' => 'order_detail_appointments'
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
            ->decimal('subtotal')
            ->allowEmpty('subtotal');

        $validator
            ->allowEmpty('validator');

        $validator
            ->decimal('total')
            ->allowEmpty('total');

        $validator
            ->allowEmpty('observations');

        $validator
            ->allowEmpty('calculated_age');

        $validator
            ->decimal('discount')
            ->allowEmpty('discount');

        $validator
            ->integer('discount_type')
            ->requirePresence('discount_type', 'create')
            ->notEmpty('discount_type');

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
        $rules->add($rules->existsIn(['clients_id'], 'Clients'));
        $rules->add($rules->existsIn(['rates_id'], 'Rates'));
        $rules->add($rules->existsIn(['users_id'], 'Users'));
        $rules->add($rules->existsIn(['patients_id'], 'Patients'));
        $rules->add($rules->existsIn(['external_specialists_id'], 'ExternalSpecialists'));
        $rules->add($rules->existsIn(['service_type_id'], 'ServiceTypes'));
        $rules->add($rules->existsIn(['order_types_id'], 'OrderTypes'));
        $rules->add($rules->existsIn(['centers_id'], 'Centers'));
        return $rules;
    }
}
