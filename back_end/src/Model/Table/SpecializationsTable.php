<?php
namespace App\Model\Table;

use App\Model\Entity\Specialization;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Specializations Model
 *
 * @property \Cake\ORM\Association\BelongsTo $CostCenters
 */
class SpecializationsTable extends Table
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

        $this->table('specializations');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CostCenters', [
            'foreignKey' => 'cost_centers_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Studies', [
            'foreignKey' => 'specialist_id',
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
            ->requirePresence('specialization', 'create')
            ->notEmpty('specialization');

        $validator
            ->allowEmpty('code');

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
        $rules->add($rules->existsIn(['cost_centers_id'], 'CostCenters'));
        return $rules;
    }
}
