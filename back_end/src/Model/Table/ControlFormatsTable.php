<?php
namespace App\Model\Table;

use App\Model\Entity\ControlFormat;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControlFormats Model
 *
 * @property \Cake\ORM\Association\BelongsTo $FormatTypes
 * @property \Cake\ORM\Association\BelongsTo $Attentions
 * @property \Cake\ORM\Association\BelongsTo $Patients
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Specialists
 */
class ControlFormatsTable extends Table
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

        $this->table('control_formats');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('FormatTypes', [
            'foreignKey' => 'format_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Attentions', [
            'foreignKey' => 'attentions_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Patients', [
            'foreignKey' => 'patients_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
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
            ->integer('has_past_studies')
            ->requirePresence('has_past_studies', 'create')
            ->notEmpty('has_past_studies');

            $validator
            ->allowEmpty('number_studies');

        $validator
            ->allowEmpty('observations');

        $validator
            ->integer('number_studies')
            ->allowEmpty('number_studies');

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
        $rules->add($rules->existsIn(['format_type_id'], 'FormatTypes'));
        $rules->add($rules->existsIn(['attentions_id'], 'Attentions'));
        $rules->add($rules->existsIn(['patients_id'], 'Patients'));
        $rules->add($rules->existsIn(['users_id'], 'Users'));
        $rules->add($rules->existsIn(['specialists_id'], 'Specialists'));
        return $rules;
    }
}
