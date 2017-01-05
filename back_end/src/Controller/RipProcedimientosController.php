<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * RipProcedimientos Controller
 *
 * @property \App\Model\Table\RipProcedimientosTable $RipProcedimientos
 */
class RipProcedimientosController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['addRipsProcess', 'getRipProcess']);
    }

    public function getRipProcess(){

        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $dateI = $data['date'];

        $dateF = $data['fechaF'];

        $clinte = $data['client'];


        // $ripProcedimientos = $this->RipProcedimientos->find('all', ['conditions'=>['RipProcedimientos.entidad'=>$clinte]]);
        // 
        
        $ripProcedimientos = $connection->execute("SELECT 
            rip_procedimientos.num_factura, 
            rip_procedimientos.cod_ips, 
            rip_procedimientos.tip_identificacion, 
            rip_procedimientos.identificacion,
            DATE_FORMAT(rip_procedimientos.fec_procedimiento, '%d/%m/%X') as fec_procedimiento,
            rip_procedimientos.num_autorizacion, 
            rip_procedimientos.cod_procedimiento,
            rip_procedimientos.ambito,
            rip_procedimientos.finalidad,
            rip_procedimientos.persona_atiende,
            rip_procedimientos.dx_prin,
            rip_procedimientos.dx_relacionado,
            rip_procedimientos.complicacion,
            rip_procedimientos.forma,
            rip_procedimientos.precio
            FROM rip_procedimientos Where 
            DATE(rip_procedimientos.fec_procedimiento) BETWEEN '$dateI' AND '$dateF'
            AND rip_procedimientos.entidad = $clinte; 
            ");


        if($ripProcedimientos){
            $ripProcedimientos = $ripProcedimientos->fetchAll('assoc');
            $success = true;

            $this->set(compact('success', 'ripProcedimientos'));

        }else{

            $success = false;

            $errors = $ripProcedimientos->errors();

            $this->set(compact('success'));
        }

    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $ripProcedimientos = $this->paginate($this->RipProcedimientos);

        $this->set(compact('ripProcedimientos'));
        $this->set('_serialize', ['ripProcedimientos']);
    }

    /**
     * View method
     *
     * @param string|null $id Rip Procedimiento id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ripProcedimiento = $this->RipProcedimientos->get($id, [
            'contain' => []
        ]);

        $this->set('ripProcedimiento', $ripProcedimiento);
        $this->set('_serialize', ['ripProcedimiento']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addRipsProcess()
    {
        $ripProcedimiento = $this->RipProcedimientos->newEntity();
       
            $ripProcedimiento = $this->RipProcedimientos->patchEntity($ripProcedimiento, $this->request->data);

            if ($this->RipProcedimientos->save($ripProcedimiento)) {


                $success = true;

                $this->set(compact('success', 'ripProcedimiento'));
               
            } else {

                $success = false;

                $errors = $ripProcedimiento->errors();

                $this->set(compact('success', 'errors'));
            }
        
      
    }

    /**
     * Edit method
     *
     * @param string|null $id Rip Procedimiento id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ripProcedimiento = $this->RipProcedimientos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ripProcedimiento = $this->RipProcedimientos->patchEntity($ripProcedimiento, $this->request->data);
            if ($this->RipProcedimientos->save($ripProcedimiento)) {
                $this->Flash->success(__('The rip procedimiento has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rip procedimiento could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ripProcedimiento'));
        $this->set('_serialize', ['ripProcedimiento']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rip Procedimiento id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ripProcedimiento = $this->RipProcedimientos->get($id);
        if ($this->RipProcedimientos->delete($ripProcedimiento)) {
            $this->Flash->success(__('The rip procedimiento has been deleted.'));
        } else {
            $this->Flash->error(__('The rip procedimiento could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
