<?php
namespace App\Model\Table;

use App\Model\Entity\Attention;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Attentions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Appointments
 */
class AttentionsTable extends Table
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

        $this->table('attentions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Appointments', [
            'foreignKey' => 'appointments_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Results', [
          'foreignKey' => 'attentions_ids',
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
            ->dateTime('date_time_ini')
            ->requirePresence('date_time_ini', 'create')
            ->notEmpty('date_time_ini');

        $validator
            ->dateTime('date_time_end')
            ->requirePresence('date_time_end', 'create')
            ->notEmpty('date_time_end');

        $validator
            ->integer('lend_plates')
            ->requirePresence('lend_plates', 'create')
            ->notEmpty('lend_plates');

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
        $rules->add($rules->existsIn(['users_id'], 'Users'));
        $rules->add($rules->existsIn(['appointments_id'], 'Appointments'));
        return $rules;
    }
}
