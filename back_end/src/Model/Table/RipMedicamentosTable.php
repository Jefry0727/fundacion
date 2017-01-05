<?php
namespace App\Model\Table;

use App\Model\Entity\RipMedicamento;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RipMedicamentos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clients
 * @property \Cake\ORM\Association\BelongsTo $Rates
 */
class RipMedicamentosTable extends Table
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

        $this->table('rip_medicamentos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Clients', [
            'foreignKey' => 'clients_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Rates', [
            'foreignKey' => 'rates_id',
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
            ->allowEmpty('num_factura');

        $validator
            ->allowEmpty('cod_ips');

        $validator
            ->allowEmpty('document_type');

        $validator
            ->allowEmpty('identificacion');

        $validator
            ->allowEmpty('num_autorizacion');

        $validator
            ->allowEmpty('cod_medicamento');

        $validator
            ->allowEmpty('tipo_medicamento');

        $validator
            ->allowEmpty('nombre_gen');

        $validator
            ->allowEmpty('form_farmaceutica');

        $validator
            ->allowEmpty('concentracion');

        $validator
            ->allowEmpty('unidad_medida');

        $validator
            ->allowEmpty('cantidad');

        $validator
            ->allowEmpty('val_unitario');

        $validator
            ->allowEmpty('val_total');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

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
        $rules->add($rules->existsIn(['clients_id'], 'Clients'));
        $rules->add($rules->existsIn(['rates_id'], 'Rates'));
        return $rules;
    }
}
