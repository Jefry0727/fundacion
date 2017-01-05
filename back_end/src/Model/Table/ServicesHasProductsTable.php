<?php
namespace App\Model\Table;

use App\Model\Entity\ServicesHasProduct;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ServicesHasProducts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Services
 * @property \Cake\ORM\Association\BelongsTo $Products
 */
class ServicesHasProductsTable extends Table
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

        $this->table('services_has_products');
        $this->displayField('services_id');
        $this->primaryKey(['services_id', 'products_id']);

        $this->belongsTo('Services', [
            'foreignKey' => 'services_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
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
        $rules->add($rules->existsIn(['products_id'], 'Products'));
        return $rules;
    }
}
