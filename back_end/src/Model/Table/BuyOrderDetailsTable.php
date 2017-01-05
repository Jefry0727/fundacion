<?php
namespace App\Model\Table;

use App\Model\Entity\BuyOrderDetail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BuyOrderDetails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $BuyOrders
 * @property \Cake\ORM\Association\BelongsTo $Products
 */
class BuyOrderDetailsTable extends Table
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

        $this->table('buy_order_details');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('BuyOrders', [
            'foreignKey' => 'buy_orders_id',
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

        $validator
            ->integer('quantity')
            ->allowEmpty('quantity');

        $validator
            ->decimal('subtotal')
            ->allowEmpty('subtotal');

        $validator
            ->decimal('individual_value')
            ->allowEmpty('individual_value');

        $validator
            ->decimal('iva')
            ->allowEmpty('iva');

        $validator
            ->decimal('total')
            ->allowEmpty('total');

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
        $rules->add($rules->existsIn(['buy_orders_id'], 'BuyOrders'));
        $rules->add($rules->existsIn(['products_id'], 'Products'));
        return $rules;
    }
}
