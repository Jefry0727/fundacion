<?php
namespace App\Model\Table;

use App\Model\Entity\InstructiveStudy;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InstructiveStudies Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Instructives
 * @property \Cake\ORM\Association\BelongsTo $Studies
 */
class InstructiveStudiesTable extends Table
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

        $this->table('instructive_studies');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Instructives', [
            'foreignKey' => 'instructives_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Studies', [
            'foreignKey' => 'studies_id',
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
        $rules->add($rules->existsIn(['instructives_id'], 'Instructives'));
        $rules->add($rules->existsIn(['studies_id'], 'Studies'));
        return $rules;
    }
}
