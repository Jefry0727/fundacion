<?php
namespace App\Model\Table;

use App\Model\Entity\Product;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Section
 * @property \Cake\ORM\Association\BelongsTo $FarmaseuticForm
 * @property \Cake\ORM\Association\BelongsToMany $ManualBills
 * @property \Cake\ORM\Association\BelongsToMany $Studies
 */
class ProductsTable extends Table
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

        $this->table('products');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Section', [
            'foreignKey' => 'section_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FarmaseuticForm', [
            'foreignKey' => 'farmaseutic_form_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('ManualBills', [
            'foreignKey' => 'product_id',
            'targetForeignKey' => 'manual_bill_id',
            'joinTable' => 'manual_bills_products'
        ]);
        $this->belongsToMany('Studies', [
            'foreignKey' => 'product_id',
            'targetForeignKey' => 'study_id',
            'joinTable' => 'products_studies'
        ]);

        $this->belongsToMany('InvimaCodes', [
            'foreignKey' => 'product_id',
            'targetForeignKey' => 'invima_codes_id',
            'joinTable' => 'invima_code_products'
        ]);

        $this->hasMany('ProductsDetails', [
            'foreignKey' => 'products_id',
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
            ->decimal('value')
            ->requirePresence('value', 'create')
            ->notEmpty('value');

        $validator
            ->integer('state')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->allowEmpty('active_principle');

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
        $rules->add($rules->existsIn(['section_id'], 'Section'));
        $rules->add($rules->existsIn(['farmaseutic_form_id'], 'FarmaseuticForm'));
        return $rules;
    }
}
