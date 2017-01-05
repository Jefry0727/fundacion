<?php
namespace App\Model\Table;

use App\Model\Entity\PruebaUsuario;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PruebaUsuario Model
 *
 */
class PruebaUsuarioTable extends Table
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

        $this->table('prueba_usuario');
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
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->requirePresence('apellido', 'create')
            ->notEmpty('apellido');

        $validator
            ->requirePresence('cedula', 'create')
            ->notEmpty('cedula');

        $validator
            ->allowEmpty('telefono');

        $validator
            ->allowEmpty('celular');

        $validator
            ->requirePresence('direccion', 'create')
            ->notEmpty('direccion');

        return $validator;
    }
}
