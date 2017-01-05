<?php
namespace App\Model\Table;

use App\Model\Entity\ProductServicesTypesService;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductServicesTypesServices Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Services
 * @property \Cake\ORM\Association\BelongsTo $ProductServicesTypes
 */
class ProductServicesTypesServicesTable extends Table
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

        $this->table('product_services_types_services');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Services', [
            'foreignKey' => 'services_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ProductServicesTypes', [
            'foreignKey' => 'product_services_types_id',
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
        $rules->add($rules->existsIn(['services_id'], 'Services'));
        $rules->add($rules->existsIn(['product_services_types_id'], 'ProductServicesTypes'));
        return $rules;
    }
}
