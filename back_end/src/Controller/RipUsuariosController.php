<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * RipUsuarios Controller
 *
 * @property \App\Model\Table\RipUsuariosTable $RipUsuarios
 */
class RipUsuariosController extends AppController
{

      public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['addUserRip', 'informationRipUser']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $ripUsuarios = $this->paginate($this->RipUsuarios);

        $this->set(compact('ripUsuarios'));
        $this->set('_serialize', ['ripUsuarios']);
    }

    /**
     * View method
     *
     * @param string|null $id Rip Usuario id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ripUsuario = $this->RipUsuarios->get($id, [
            'contain' => []
        ]);

        $this->set('ripUsuario', $ripUsuario);
        $this->set('_serialize', ['ripUsuario']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addUserRip()
    {

        //$this->autoRender = false;

       

            $ripUsuario = $this->RipUsuarios->newEntity();
          
                $ripUsuario = $this->RipUsuarios->patchEntity($ripUsuario, $this->request->data);

                if ($this->RipUsuarios->save($ripUsuario)) {

                   $success = true;

                   $this->set(compact('success', 'ripUsuario'));

                } else {

                   $success = false;

                   $errors = $ripUsuario->errors();

                   $this->set(compact('success', 'errors')); 
                }
            
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Rip Usuario id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ripUsuario = $this->RipUsuarios->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ripUsuario = $this->RipUsuarios->patchEntity($ripUsuario, $this->request->data);
            if ($this->RipUsuarios->save($ripUsuario)) {
                $this->Flash->success(__('The rip usuario has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rip usuario could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ripUsuario'));
        $this->set('_serialize', ['ripUsuario']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rip Usuario id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ripUsuario = $this->RipUsuarios->get($id);
        if ($this->RipUsuarios->delete($ripUsuario)) {
            $this->Flash->success(__('The rip usuario has been deleted.'));
        } else {
            $this->Flash->error(__('The rip usuario could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function informationRipUser(){

        $connection = ConnectionManager::get('default');

        $client = $this->request->data['client'];

        $fechaI = $this->request->data['fechaI'];

        $fecha = $this->request->data['fechaF'];
        
        $rips = $connection->execute("SELECT * FROM rip_usuarios  Where DATE(rip_usuarios.fecha) BETWEEN '$fechaI' AND '$fecha' AND rip_usuarios.entidad = $client");

        if($rips){

            $success = true;

            $rips = $rips->fetchAll('assoc');

            $this->set(compact('success','rips'));

        }else{

            $success = false;

            $errors = $rips->errors();

            $this->set(compact('success', 'errors'));
        }

    }
}
