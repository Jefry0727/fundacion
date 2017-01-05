<?php
namespace App\Model\Table;

use App\Model\Entity\Person;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * People Model
 *
 * @property \Cake\ORM\Association\BelongsTo $DocumentTypes
 * @property \Cake\ORM\Association\BelongsTo $Municipalities
 */
class PeopleTable extends Table
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

        $this->table('people');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('DocumentTypes', [
            'foreignKey' => 'document_types_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Municipalities', [
            'foreignKey' => 'municipalities_id',
            'joinType' => 'INNER'
        ]);
           $this->hasMany('Patients', [
            'foreignKey' => 'people_id'
        ]);

        $this->hasMany('Users', [
            'foreignKey' => 'people_id'
        ]);
        $this->hasOne('Gender',[
            'foreignKey' => 'gender',
            'propertyName' => 'gender'
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
            ->requirePresence('identification', 'create')
            ->notEmpty('identification')
            ->add('identification', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->allowEmpty('middle_name');

        $validator
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');

        $validator
            ->allowEmpty('last_name_two');

        $validator
            ->date('birthdate')
            ->requirePresence('birthdate', 'create')
            ->notEmpty('birthdate');

        $validator
            ->integer('gender')
            ->requirePresence('gender', 'create')
            ->notEmpty('gender');

        $validator
            ->allowEmpty('address');

        $validator
            ->allowEmpty('phone');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->integer('user_creation')
            ->requirePresence('user_creation', 'create')
            ->notEmpty('user_creation');

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
        $rules->add($rules->isUnique(['identification']));
        $rules->add($rules->existsIn(['document_types_id'], 'DocumentTypes'));
        $rules->add($rules->existsIn(['municipalities_id'], 'Municipalities'));
        return $rules;
    }
}
