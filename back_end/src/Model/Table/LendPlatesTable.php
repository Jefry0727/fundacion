<?php
namespace App\Model\Table;

use App\Model\Entity\LendPlate;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LendPlates Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Attentions
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class LendPlatesTable extends Table
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

        $this->table('lend_plates');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Attentions', [
            'foreignKey' => 'attentions_id',
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
            ->requirePresence('observations', 'create')
            ->notEmpty('observations');

        $validator
            ->allowEmpty('delivered');

        $validator
            ->allowEmpty('phone');

        $validator
            ->integer('returned')
            ->requirePresence('returned', 'create')
            ->notEmpty('returned');

        $validator
            ->dateTime('return_date')
            ->allowEmpty('return_date');

        $validator
            ->allowEmpty('direction');

        $validator
            ->requirePresence('document', 'create')
            ->notEmpty('document');

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
        $rules->add($rules->existsIn(['users_id'], 'Users'));
        return $rules;
    }
}
