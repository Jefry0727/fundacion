<?php
namespace App\Model\Table;

use App\Model\Entity\RipDescripcion;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RipDescripcion Model
 *
 */
class RipDescripcionTable extends Table
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

        $this->table('rip_descripcion');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->allowEmpty('num_factura');

        $validator
            ->allowEmpty('cod_ips');

        $validator
            ->allowEmpty('cod_concepto');

        $validator
            ->allowEmpty('cantidad');

        $validator
            ->allowEmpty('val_unitario');

        $validator
            ->allowEmpty('val_concepto');

        return $validator;
    }
}
