<?php
namespace App\Model\Table;

use App\Model\Entity\SpecialistsAvailable;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SpecialistsAvailables Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Specialists
 * @property \Cake\ORM\Association\BelongsTo $ServiceTypes
 */
class SpecialistsAvailablesTable extends Table
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

        $this->table('specialists_availables');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Specialists', [
            'foreignKey' => 'specialists_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ServiceTypes', [
            'foreignKey' => 'service_type_id',
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
            ->integer('state')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

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
        $rules->add($rules->existsIn(['service_type_id'], 'ServiceTypes'));
        return $rules;
    }
}
