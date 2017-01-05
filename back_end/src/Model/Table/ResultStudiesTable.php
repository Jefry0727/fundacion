<?php
namespace App\Model\Table;

use App\Model\Entity\ResultStudy;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResultStudies Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Attentions
 * @property \Cake\ORM\Association\BelongsTo $Specialists
 */
class ResultStudiesTable extends Table
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

        $this->table('result_studies');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Attentions', [
            'foreignKey' => 'attentions_id',
            'joinType' => 'INNER'
        ]);
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');

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
        $rules->add($rules->existsIn(['attentions_id'], 'Attentions'));
        $rules->add($rules->existsIn(['specialists_id'], 'Specialists'));
        return $rules;
    }
}
