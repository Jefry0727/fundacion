<?php
namespace App\Model\Table;

use App\Model\Entity\Order;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Orders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clients
 * @property \Cake\ORM\Association\BelongsTo $Rates
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Patients
 * @property \Cake\ORM\Association\BelongsTo $ExternalSpecialists
 * @property \Cake\ORM\Association\BelongsTo $ServiceTypes
 * @property \Cake\ORM\Association\BelongsTo $Centers
 * @property \Cake\ORM\Association\BelongsTo $OrderStates
 * @property \Cake\ORM\Association\BelongsTo $CieTenCodes
 * @property \Cake\ORM\Association\BelongsTo $ConsultationEndings
 * @property \Cake\ORM\Association\BelongsTo $ExternalCauses
 * @property \Cake\ORM\Association\BelongsTo $CostCenters
 * @property \Cake\ORM\Association\BelongsTo $BillTypes
 * @property \Cake\ORM\Association\BelongsToMany $Bills
 */
class OrdersTable extends Table
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

        $this->table('orders');
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
        $this->belongsTo('Centers', [
            'foreignKey' => 'centers_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrderStates', [
            'foreignKey' => 'order_states_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CieTenCodes', [
            'foreignKey' => 'cie_ten_codes_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ConsultationEndings', [
            'foreignKey' => 'consultation_endings_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ExternalCauses', [
            'foreignKey' => 'external_causes_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CostCenters', [
            'foreignKey' => 'cost_centers_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('BillTypes', [
            'foreignKey' => 'bill_types_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Bills', [
            'foreignKey' => 'order_id',
            'targetForeignKey' => 'bill_id',
            'joinTable' => 'orders_bills'
        ]);


          $this->belongsToMany('Appointments', [
            'foreignKey' => 'orders_id',
            'targetForeignKey' => 'appointments_id',
            'joinTable' => 'order_appointments'
        ]);

  
 
        // $this->hasMany('Bills', [
        //     'foreignKey' => 'orders_id',
        // ]);

        $this->hasMany('payments', [
            'foreignKey' => 'orders_id',
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
            ->requirePresence('order_consec', 'create')
            ->notEmpty('order_consec');

        $validator
            ->allowEmpty('validator');

        $validator
            ->allowEmpty('calculated_age');

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
            ->decimal('copayment')
            ->allowEmpty('copayment');

        $validator
            ->integer('discount_type')
            ->allowEmpty('discount_type');

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
        $rules->add($rules->existsIn(['centers_id'], 'Centers'));
        $rules->add($rules->existsIn(['order_states_id'], 'OrderStates'));
        $rules->add($rules->existsIn(['cie_ten_codes_id'], 'CieTenCodes'));
        $rules->add($rules->existsIn(['consultation_endings_id'], 'ConsultationEndings'));
        $rules->add($rules->existsIn(['external_causes_id'], 'ExternalCauses'));
        $rules->add($rules->existsIn(['cost_centers_id'], 'CostCenters'));
        $rules->add($rules->existsIn(['bill_types_id'], 'BillTypes'));
        return $rules;
    }
    


      public function getOrderByPatient($idPatient){
          $conn = ConnectionManager::get('default');
        // Obtiene todos los resultados de un paciente.
          var_dump($idPatient);
        $query = $conn->execute(
            "SELECT

             orders.order_consec as order_code, 
                orders.created as order_date,
                appointments.id as appointment,
                studies.cup as study_code,
                studies.name as study_name,
                attentions.id as attention_code,
                attentions.date_time_ini as attention_date,
                attentions.lend_plates as lend_plates,
                results.id as result_code,
                results.created as result_date,
                results.content as result_content,
                results.specialists_id as result_specialist_code,
                orders.patients_id as patient_id,
                orders.calculated_age as patient_edad,
                clients.name as client
            from orders
            left join order_appointments on  orders.id = order_appointments.orders_id
            left join appointments on order_appointments.appointments_id = appointments.id 
            left join studies  on appointments.studies_id = studies.id
            left join attentions on attentions.appointments_id = appointments.id
            left join results on results.attentions_id = attentions.id
            left join clients on clients.id = orders.clients_id
            where attentions.id is not null  
                and  (results.id is not null or attentions.lend_plates is not null) 
                and  orders.patients_id =".$idPatient."
                group by 1,2")->fetchAll('assoc'); 
        

        return $query;

    }

    public function getResultByPatient($idPatient){
        $conn = ConnectionManager::get('default');
        // Obtiene todos los resultados de un paciente.
        $query = $conn->execute(
            "SELECT
             orders.order_consec as order_code, 
                orders.created as order_date,
                appointments.id as appointment,
                studies.cup as study_code,
                studies.name as study_name,
                attentions.id as attention_code,
                attentions.date_time_ini as attention_date,
                attentions.lend_plates as lend_plates,
                results.id as result_code,
                attentions.id as attentions_id,
                results.created as result_date,
                results.content as result_content,
                results.specialists_id as result_specialist_code,
                orders.patients_id as patient_id,
                orders.calculated_age as patient_edad,
                clients.name as client
            from orders
            left join order_appointments on  orders.id = order_appointments.orders_id
            left join appointments on order_appointments.appointments_id = appointments.id 
            left join studies  on appointments.studies_id = studies.id
            left join attentions on attentions.appointments_id = appointments.id
            left join results on attentions.id = results.attentions_id
            left join clients on clients.id = orders.clients_id
            where attentions.id is not null and results.id = (SELECT MAX(rs.id) FROM results rs WHERE rs.attentions_id = attentions.id)
                and ( results.id is not null or attentions.lend_plates is not null)
                and  orders.patients_id =".$idPatient)->fetchAll('assoc'); 
        return $query;

    }

    public function getResultByOrder($order){
     
        $conn = ConnectionManager::get('default');
        // Obtiene todos los resultados de un paciente.
        $query = $conn->execute(
            "SELECT
               orders.order_consec as order_code, 
                orders.created as order_date,
                appointments.id as appointment,
                studies.cup as study_code,
                studies.name as study_name,
                attentions.id as attention_code,
                attentions.date_time_ini as attention_date,
                attentions.lend_plates as lend_plates,
                results.id as result_code,
                results.created as result_date,
                results.content as result_content,
                results.specialists_id as result_specialist_code,
                orders.patients_id as patient_id,
                orders.calculated_age as patient_edad,
                clients.name as client
            from orders
            left join order_appointments on  orders.id = order_appointments.orders_id
            left join appointments on order_appointments.appointments_id = appointments.id 
            left join studies  on appointments.studies_id = studies.id
            left join attentions on attentions.appointments_id = appointments.id
            left join results on results.attentions_id = attentions.id
            left join clients on clients.id = orders.clients_id
            where attentions.id is not null and results.id = (SELECT MAX(rs.id) FROM results rs WHERE rs.attentions_id = attentions.id)
                and  (results.id is not null or attentions.lend_plates is not null) 
                and  orders.order_consec  ='".$order."'")->fetchAll('assoc'); 

        return $query;

    }

}
