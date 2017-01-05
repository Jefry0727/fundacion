<?php
namespace App\Model\Table;

use App\Model\Entity\BillResolution;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillResolutions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ResolutionConcepts
 * @property \Cake\ORM\Association\BelongsTo $Centers
 * @property \Cake\ORM\Association\BelongsTo $BillTypes
 */
class BillResolutionsTable extends Table
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

        $this->table('bill_resolutions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('ResolutionConcepts', [
            'foreignKey' => 'resolution_concepts_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Centers', [
            'foreignKey' => 'center_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('BillTypes', [
            'foreignKey' => 'bill_types_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Bills', [
            'foreignKey' => 'id',
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
            ->date('date_expeditions')
            ->requirePresence('date_expeditions', 'create')
            ->notEmpty('date_expeditions');

        $validator
            ->date('date_expiration')
            ->requirePresence('date_expiration', 'create')
            ->notEmpty('date_expiration');

        $validator
            ->requirePresence('resolution', 'create')
            ->notEmpty('resolution');

        $validator
            ->requirePresence('prefix', 'create')
            ->notEmpty('prefix');

        $validator
            ->integer('ini')
            ->requirePresence('ini', 'create')
            ->notEmpty('ini');

        $validator
            ->integer('end')
            ->requirePresence('end', 'create')
            ->notEmpty('end');

        $validator
            ->integer('current_number')
            ->requirePresence('current_number', 'create')
            ->notEmpty('current_number');

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
        $rules->add($rules->existsIn(['resolution_concepts_id'], 'ResolutionConcepts'));
        $rules->add($rules->existsIn(['center_id'], 'Centers'));
        $rules->add($rules->existsIn(['bill_types_id'], 'BillTypes'));
        return $rules;
    }
}
