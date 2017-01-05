<?php
namespace App\Model\Table;

use App\Model\Entity\Appointment;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Appointments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $MedicalOffices
 * @property \Cake\ORM\Association\BelongsTo $Studies
 */
class AppointmentsTable extends Table
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

        $this->table('appointments');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('MedicalOffices', [
            'foreignKey' => 'medical_offices_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Studies', [
            'foreignKey' => 'studies_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Attentions', [
            'foreignKey' => 'appointments_id',
        ]);

        $this->hasMany('AppointmentDates', [
            'foreignKey' => 'appointments_id',
        ]);
  
        $this->belongsToMany('Orders', [
                'foreignKey' => 'appointments_id',
                'targetForeignKey' => 'orders_id',
                'joinTable' => 'order_appointments'
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
            ->numeric('studies_value')
            ->allowEmpty('studies_value');

        $validator
            ->integer('type')
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->allowEmpty('observations');

        $validator
            ->date('expected_date')
            ->requirePresence('expected_date', 'create')
            ->notEmpty('expected_date');

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
        $rules->add($rules->existsIn(['medical_offices_id'], 'MedicalOffices'));
        $rules->add($rules->existsIn(['studies_id'], 'Studies'));
        return $rules;
    }
}
