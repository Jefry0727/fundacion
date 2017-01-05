<?php
namespace App\Model\Table;

use App\Model\Entity\StudiesSpecialist;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StudiesSpecialists Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Studies
 * @property \Cake\ORM\Association\BelongsTo $Specialists
 */
class StudiesSpecialistsTable extends Table
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

        $this->table('studies_specialists');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Studies', [
            'foreignKey' => 'studies_id',
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
        $rules->add($rules->existsIn(['specialists_id'], 'Specialists'));
        return $rules;
    }
}
