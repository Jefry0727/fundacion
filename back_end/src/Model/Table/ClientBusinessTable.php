<?php
namespace App\Model\Table;

use App\Model\Entity\ClientBusines;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientBusiness Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clients
 * @property \Cake\ORM\Association\BelongsTo $BusinessTerms
 */
class ClientBusinessTable extends Table
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

        $this->table('client_business');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'clients_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('BusinessTerms', [
            'foreignKey' => 'business_terms_id',
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
            ->allowEmpty('observation');

        $validator
            ->decimal('capital')
            ->allowEmpty('capital');

        $validator
            ->integer('type')
            ->allowEmpty('type');

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
        $rules->add($rules->existsIn(['clients_id'], 'Clients'));
        $rules->add($rules->existsIn(['business_terms_id'], 'BusinessTerms'));
        return $rules;
    }
}
