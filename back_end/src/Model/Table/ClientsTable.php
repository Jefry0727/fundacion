<?php
namespace App\Model\Table;

use App\Model\Entity\Client;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clients Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Municipalities
 * @property \Cake\ORM\Association\BelongsTo $TypesClient
 * @property \Cake\ORM\Association\BelongsToMany $Rates
 */
class ClientsTable extends Table
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

        $this->table('clients');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Municipalities', [
            'foreignKey' => 'municipalities_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TypesClient', [
            'foreignKey' => 'types_client_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Rates', [
            'foreignKey' => 'client_id',
            'targetForeignKey' => 'rate_id',
            'joinTable' => 'rates_clients'
        ]);
        $this->hasMany('ClientContacts', [
            'foreignKey' => 'clients_id',
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('nit', 'create')
            ->notEmpty('nit');

        $validator
            ->allowEmpty('social_reazon');

        $validator
            ->allowEmpty('ars_code');

        $validator
            ->allowEmpty('address');

        $validator
            ->allowEmpty('responsible');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->allowEmpty('phone');

        $validator
            ->allowEmpty('phone2');

        $validator
            ->integer('state')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->requirePresence('ciiu', 'create')
            ->notEmpty('ciiu');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['municipalities_id'], 'Municipalities'));
        $rules->add($rules->existsIn(['types_client_id'], 'TypesClient'));
        return $rules;
    }
}
