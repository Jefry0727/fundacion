<?php
namespace App\Model\Table;

use App\Model\Entity\RateStudy;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RateStudies Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Studies
 * @property \Cake\ORM\Association\BelongsTo $RatesClients
 */
class RateStudiesTable extends Table
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

        $this->table('rate_studies');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Studies', [
            'foreignKey' => 'studies_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('RatesClients', [
            'foreignKey' => 'rates_clients_id',
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
            ->decimal('value')
            ->requirePresence('value', 'create')
            ->notEmpty('value');

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
        $rules->add($rules->existsIn(['studies_id'], 'Studies'));
        $rules->add($rules->existsIn(['rates_clients_id'], 'RatesClients'));
        return $rules;
    }
}
