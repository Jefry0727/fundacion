<?php
namespace App\Model\Table;

use App\Model\Entity\ScheduleEspecialistRestriction;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ScheduleEspecialistRestrictions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Specialists
 */
class ScheduleEspecialistRestrictionsTable extends Table
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

        $this->table('schedule_especialist_restrictions');
        $this->displayField('Id');
        $this->primaryKey('Id');

        $this->belongsTo('Specialists', [
            'foreignKey' => 'specialists_id',
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
            ->integer('Id')
            ->allowEmpty('Id', 'create');

        $validator
            ->allowEmpty('description');

        $validator
            ->dateTime('date_ini')
            ->allowEmpty('date_ini');

        $validator
            ->dateTime('date_end')
            ->allowEmpty('date_end');

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
        return $rules;
    }
}
