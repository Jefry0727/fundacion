<?php
namespace App\Model\Table;

use App\Model\Entity\Study;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Studies Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Specializations
 * @property \Cake\ORM\Association\BelongsTo $FormatTypes
 * @property \Cake\ORM\Association\BelongsToMany $Products
 * @property \Cake\ORM\Association\BelongsToMany $InformedConsents
 * @property \Cake\ORM\Association\BelongsToMany $MedicalOffices
 * @property \Cake\ORM\Association\BelongsToMany $Specialists
 */
class StudiesTable extends Table
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

        $this->table('studies');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Specializations', [
            'foreignKey' => 'specializations_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FormatTypes', [
            'foreignKey' => 'format_types_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'study_id',
            'targetForeignKey' => 'product_id',
            'joinTable' => 'products_studies'
        ]);
        $this->belongsToMany('InformedConsents', [
            'foreignKey' => 'study_id',
            'targetForeignKey' => 'informed_consent_id',
            'joinTable' => 'studies_informed_consents'
        ]);
        $this->belongsToMany('MedicalOffices', [
            'foreignKey' => 'study_id',
            'targetForeignKey' => 'medical_office_id',
            'joinTable' => 'studies_medical_offices'
        ]);
        $this->belongsToMany('Specialists', [
            'foreignKey' => 'study_id',
            'targetForeignKey' => 'specialist_id',
            'joinTable' => 'studies_specialists'
        ]);

        $this->belongsTo('ServiceTypes', [
            'foreignKey' => 'service_types_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsToMany('Services', [
            'foreignKey' => 'studies_id',
            'targetForeignKey' => 'servicises_id',
            'joinTable' => 'products_studies'
        ]);


        $this->belongsToMany('Instructives', [
            'foreignKey' => 'studies_id',
            'targetForeignKey' => 'instructives_id',
            'joinTable' => 'instructive_studies'
        ]);

        $this->hasMany('StudiesInformedConsents', [
            'foreignKey' => 'studies_id',
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
            ->requirePresence('cup', 'create')
            ->notEmpty('cup');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('average_time')
            ->allowEmpty('average_time');

        $validator
            ->allowEmpty('type');

        $validator
            ->allowEmpty('coments');

        $validator
            ->decimal('radiation_dose')
            ->requirePresence('radiation_dose', 'create')
            ->notEmpty('radiation_dose');

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
        $rules->add($rules->existsIn(['specializations_id'], 'Specializations'));
        $rules->add($rules->existsIn(['format_types_id'], 'FormatTypes'));
        return $rules;
    }
}
