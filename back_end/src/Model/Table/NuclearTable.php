<?php
namespace App\Model\Table;

use App\Model\Entity\Nuclear;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Nuclear Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ControlFormats
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class NuclearTable extends Table
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

        $this->table('nuclear');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ControlFormats', [
            'foreignKey' => 'control_formats_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
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
            ->integer('broken_plate')
            ->requirePresence('broken_plate', 'create')
            ->notEmpty('broken_plate');

        $validator
            ->allowEmpty('broken_plate_cause');

        $validator
            ->decimal('radiation_dose_mci')
            ->allowEmpty('radiation_dose_mci');

        $validator
            ->requirePresence('format_consec', 'create')
            ->notEmpty('format_consec');

        $validator
            ->allowEmpty('radiopharmaceutical');

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
        $rules->add($rules->existsIn(['control_formats_id'], 'ControlFormats'));
        $rules->add($rules->existsIn(['users_id'], 'Users'));
        return $rules;
    }
}
