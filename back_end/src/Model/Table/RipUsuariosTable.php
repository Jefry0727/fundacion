<?php
namespace App\Model\Table;

use App\Model\Entity\RipUsuario;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RipUsuarios Model
 *
 */
class RipUsuariosTable extends Table
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

        $this->table('rip_usuarios');
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
            ->allowEmpty('tipo');

        $validator
            ->allowEmpty('identificacion');

        $validator
            ->allowEmpty('cod_ars');

        $validator
            ->allowEmpty('tipo_usuario');

        $validator
            ->allowEmpty('apellido1');

        $validator
            ->allowEmpty('apellido2');

        $validator
            ->allowEmpty('nombre1');

        $validator
            ->allowEmpty('nombre2');

        $validator
            ->allowEmpty('edad');

        $validator
            ->allowEmpty('edad_unidad');

        $validator
            ->allowEmpty('sexo');

        $validator
            ->allowEmpty('cod_depto');

        $validator
            ->allowEmpty('cod_municipio');

        $validator
            ->allowEmpty('zona');

        $validator
            ->dateTime('fecha')
            ->allowEmpty('fecha');

        $validator
            ->allowEmpty('entidad');

        $validator
            ->integer('state')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->requirePresence('orderConsectuiva', 'create')
            ->notEmpty('orderConsectuiva');

        $validator
            ->allowEmpty('clientName');

        $validator
            ->allowEmpty('ratesName');

        $validator
            ->integer('stateClient')
            ->allowEmpty('stateClient');

        $validator
            ->integer('stateRates')
            ->allowEmpty('stateRates');

        $validator
            ->integer('idrRatesClient')
            ->allowEmpty('idrRatesClient');

        return $validator;
    }
}
