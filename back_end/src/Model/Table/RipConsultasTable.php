<?php
namespace App\Model\Table;

use App\Model\Entity\RipConsulta;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RipConsultas Model
 *
 */
class RipConsultasTable extends Table
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

        $this->table('rip_consultas');
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
            ->allowEmpty('identificacion');

        $validator
            ->allowEmpty('num_identificacion');

        $validator
            ->dateTime('fec_consulta')
            ->allowEmpty('fec_consulta');

        $validator
            ->allowEmpty('num_autorizacion');

        $validator
            ->allowEmpty('cod_consulta');

        $validator
            ->allowEmpty('finalidad');

        $validator
            ->allowEmpty('causa_externa');

        $validator
            ->allowEmpty('cod_dx');

        $validator
            ->allowEmpty('cod_dx_rel1');

        $validator
            ->allowEmpty('cod_dx_rel2');

        $validator
            ->allowEmpty('cod_dx_rel3');

        $validator
            ->allowEmpty('tipo_dx');

        $validator
            ->allowEmpty('val_consulta');

        $validator
            ->allowEmpty('val_copago');

        $validator
            ->allowEmpty('val_neto');

        $validator
            ->allowEmpty('entidad');

        $validator
            ->integer('tipoEstudio')
            ->allowEmpty('tipoEstudio');

        return $validator;
    }
}
