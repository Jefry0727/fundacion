<?php
namespace App\Model\Table;

use App\Model\Entity\ProductServicesType;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductServicesTypes Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Services
 */
class ProductServicesTypesTable extends Table
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

        $this->table('product_services_types');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsToMany('Services', [
            'foreignKey' => 'product_services_type_id',
            'targetForeignKey' => 'service_id',
            'joinTable' => 'product_services_types_services'
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
            ->allowEmpty('numerical_indicator');

        return $validator;
    }
}
