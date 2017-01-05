<?php
namespace App\Model\Table;

use App\Model\Entity\RipProcedimiento;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RipProcedimientos Model
 *
 */
class RipProcedimientosTable extends Table
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

        $this->table('rip_procedimientos');
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
            ->allowEmpty('tip_identificacion');

        $validator
            ->allowEmpty('identificacion');

        $validator
            ->dateTime('fec_procedimiento')
            ->allowEmpty('fec_procedimiento');

        $validator
            ->allowEmpty('num_autorizacion');

        $validator
            ->allowEmpty('cod_procedimiento');

        $validator
            ->allowEmpty('ambito');

        $validator
            ->allowEmpty('finalidad');

        $validator
            ->allowEmpty('persona_atiende');

        $validator
            ->allowEmpty('dx_prin');

        $validator
            ->allowEmpty('dx_relacionado');

        $validator
            ->allowEmpty('complicacion');

        $validator
            ->allowEmpty('forma');

        $validator
            ->numeric('precio')
            ->allowEmpty('precio');

        $validator
            ->allowEmpty('entidad');

        $validator
            ->integer('state')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        return $validator;
    }
}
