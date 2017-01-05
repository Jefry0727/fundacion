<?php
namespace App\Model\Table;

use App\Model\Entity\ClientContact;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientContacts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ContactTypes
 * @property \Cake\ORM\Association\BelongsTo $Clients
 */
class ClientContactsTable extends Table
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

        $this->table('client_contacts');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('ContactTypes', [
            'foreignKey' => 'contact_types_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Clients', [
            'foreignKey' => 'clients_id',
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
            ->allowEmpty('name');

        $validator
            ->allowEmpty('phone');

        $validator
            ->email('email')
            ->allowEmpty('email');

        return $validator;
    }


    /**
     * [addInitialContacs description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-12
     * @datetime 2016-09-12T10:16:18-0500
     * @param    [type]                   $id [Id Client]
     */
    public function addInitialContacs($id)
    {
        for ($i=1; $i<=4 ; $i++) { 
            
            $newClienteContact = ['name'=> '', 'phone'=> '', 'email'=>'', 'contact_types_id' => $i, 'clients_id'=> $id];


            $ClientContact = $this->Clients->newEntity();


            $ClientContact = $this->Clients->patchEntity($ClientContact, $newClienteContact);
      
          
            if (!$this->Clients->save($ClientContact)) {
            
                return false;       
                break;
            }


        }

        return true;

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
        $rules->add($rules->existsIn(['contact_types_id'], 'ContactTypes'));
        $rules->add($rules->existsIn(['clients_id'], 'Clients'));
        return $rules;
    }
}
