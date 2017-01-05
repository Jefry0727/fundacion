<?php
namespace App\Model\Table;

use App\Model\Entity\ScheduleSpecialist;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ScheduleSpecialists Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Specialists
 * @property \Cake\ORM\Association\BelongsTo $ScheduleSpecialistTypes
 * @property \Cake\ORM\Association\BelongsTo $MedicalOffices
 */
class ScheduleSpecialistsTable extends Table
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

        $this->table('schedule_specialists');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Specialists', [
            'foreignKey' => 'specialists_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ScheduleSpecialistTypes', [
            'foreignKey' => 'schedule_specialist_types_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('MedicalOffices', [
            'foreignKey' => 'medical_offices_id',
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
            ->integer('day')
            ->requirePresence('day', 'create')
            ->notEmpty('day');

        $validator
            ->time('time_ini')
            ->requirePresence('time_ini', 'create')
            ->notEmpty('time_ini');

        $validator
            ->time('time_end')
            ->requirePresence('time_end', 'create')
            ->notEmpty('time_end');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

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
        $rules->add($rules->existsIn(['specialists_id'], 'Specialists'));
        $rules->add($rules->existsIn(['schedule_specialist_types_id'], 'ScheduleSpecialistTypes'));
        $rules->add($rules->existsIn(['medical_offices_id'], 'MedicalOffices'));
        return $rules;
    }
}
