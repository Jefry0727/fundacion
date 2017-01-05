<?php
namespace App\Model\Table;

use App\Model\Entity\RipControle;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RipControles Model
 *
 */
class RipControlesTable extends Table
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

        $this->table('rip_controles');
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
            ->allowEmpty('codigo_ips');

        $validator
            ->dateTime('fec_remision')
            ->allowEmpty('fec_remision');

        $validator
            ->allowEmpty('cod_archivo');

        $validator
            ->allowEmpty('total_registro');

        $validator
            ->allowEmpty('entidad');

        return $validator;
    }
}
