<?php
namespace App\Model\Table;

use App\Model\Entity\SubSpecializationSpecialist;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SubSpecializationSpecialists Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Specialists
 * @property \Cake\ORM\Association\BelongsTo $SubEspecializations
 */
class SubSpecializationSpecialistsTable extends Table
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

        $this->table('sub_specialization_specialists');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Specialists', [
            'foreignKey' => 'specialists_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SubEspecializations', [
            'foreignKey' => 'sub_especializations_id',
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
        $rules->add($rules->existsIn(['specialists_id'], 'Specialists'));
        $rules->add($rules->existsIn(['sub_especializations_id'], 'SubEspecializations'));
        return $rules;
    }
}
