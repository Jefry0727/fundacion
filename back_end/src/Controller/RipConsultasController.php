<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * RipConsultas Controller
 *
 * @property \App\Model\Table\RipConsultasTable $RipConsultas
 */
class RipConsultasController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['addRipQueryFiles', 'getRipArchivoConsulta']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $ripConsultas = $this->paginate($this->RipConsultas);

        $this->set(compact('ripConsultas'));
        $this->set('_serialize', ['ripConsultas']);
    }

    /**
     * View method
     *
     * @param string|null $id Rip Consulta id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ripConsulta = $this->RipConsultas->get($id, [
            'contain' => []
        ]);

        $this->set('ripConsulta', $ripConsulta);
        $this->set('_serialize', ['ripConsulta', 'getRipArchivoConsulta']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addRipQueryFiles()
    {
        $ripConsulta = $this->RipConsultas->newEntity();
        
            $ripConsulta = $this->RipConsultas->patchEntity($ripConsulta, $this->request->data);

            if ($this->RipConsultas->save($ripConsulta)) {

                $success = true;

                $this->set(compact('success', 'ripConsulta'));
               
            } else {

                
                $success = false;

                $errors = $ripConsulta->errors();

                $this->set(compact('success', 'errors'));

            }
    }


    public function getRipArchivoConsulta(){

        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $client = $data['id'];

        $fechaI = $data['fechaI'];

        $fechaF = $data['fechaF'];


        $query = $connection->execute("SELECT 
            rip_consultas.num_factura, 
            rip_consultas.cod_ips,
            rip_consultas.identificacion,
            rip_consultas.num_identificacion,
            DATE_FORMAT(rip_consultas.fec_consulta,'%d/%m/%X') as fec_consulta,
            rip_consultas.num_autorizacion,
            rip_consultas.cod_consulta,
            rip_consultas.finalidad,
            rip_consultas.cod_dx,
            rip_consultas.cod_dx_rel1,
            rip_consultas.cod_dx_rel2,
            rip_consultas.cod_dx_rel3,
            rip_consultas.tipo_dx,
            rip_consultas.val_consulta,
            rip_consultas.val_copago,
            rip_consultas.val_neto
            FROM rip_consultas
            Where DATE(rip_consultas.fec_consulta) BETWEEN '$fechaI' AND '$fechaF'
            AND rip_consultas.entidad = $client
            ")->fetchAll('assoc');

        if($query){

            $success = true;

            $this->set(compact('success', 'query'));
        }else{

            $success = false;

            $errors = $query->errors();

            $this->set(compact('success', 'errors'));

        }

    }

    /**
     * Edit method
     *
     * @param string|null $id Rip Consulta id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ripConsulta = $this->RipConsultas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ripConsulta = $this->RipConsultas->patchEntity($ripConsulta, $this->request->data);
            if ($this->RipConsultas->save($ripConsulta)) {
                $this->Flash->success(__('The rip consulta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rip consulta could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ripConsulta'));
        $this->set('_serialize', ['ripConsulta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rip Consulta id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ripConsulta = $this->RipConsultas->get($id);
        if ($this->RipConsultas->delete($ripConsulta)) {
            $this->Flash->success(__('The rip consulta has been deleted.'));
        } else {
            $this->Flash->error(__('The rip consulta could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
