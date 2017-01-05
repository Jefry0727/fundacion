<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ControlFormats Controller
 *
 * @property \App\Model\Table\ControlFormatsTable $ControlFormats
 */
class ControlFormatsController extends AppController
{

      public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['save']);
        $this->loadComponent('ResourceManager');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['FormatTypes', 'Attentions', 'Patients', 'Users', 'Specialists']
        ];
        $controlFormats = $this->paginate($this->ControlFormats);

        $this->set(compact('controlFormats'));
        $this->set('_serialize', ['controlFormats']);
    }

    /**
     * View method
     *
     * @param string|null $id Control Format id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $controlFormat = $this->ControlFormats->get($id, [
            'contain' => ['FormatTypes', 'Attentions', 'Patients', 'Users', 'Specialists']
        ]);

        $this->set('controlFormat', $controlFormat);
        $this->set('_serialize', ['controlFormat']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $controlFormat = $this->ControlFormats->newEntity();
        if ($this->request->is('post')) {
            $controlFormat = $this->ControlFormats->patchEntity($controlFormat, $this->request->data);
            if ($this->ControlFormats->save($controlFormat)) {
                $this->Flash->success(__('The control format has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The control format could not be saved. Please, try again.'));
            }
        }
        $formatTypes = $this->ControlFormats->FormatTypes->find('list', ['limit' => 200]);
        $attentions = $this->ControlFormats->Attentions->find('list', ['limit' => 200]);
        $patients = $this->ControlFormats->Patients->find('list', ['limit' => 200]);
        $users = $this->ControlFormats->Users->find('list', ['limit' => 200]);
        $specialists = $this->ControlFormats->Specialists->find('list', ['limit' => 200]);
        $this->set(compact('controlFormat', 'formatTypes', 'attentions', 'patients', 'users', 'specialists'));
        $this->set('_serialize', ['controlFormat']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Control Format id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $controlFormat = $this->ControlFormats->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $controlFormat = $this->ControlFormats->patchEntity($controlFormat, $this->request->data);
            if ($this->ControlFormats->save($controlFormat)) {
                $this->Flash->success(__('The control format has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The control format could not be saved. Please, try again.'));
            }
        }
        $formatTypes = $this->ControlFormats->FormatTypes->find('list', ['limit' => 200]);
        $attentions = $this->ControlFormats->Attentions->find('list', ['limit' => 200]);
        $patients = $this->ControlFormats->Patients->find('list', ['limit' => 200]);
        $users = $this->ControlFormats->Users->find('list', ['limit' => 200]);
        $specialists = $this->ControlFormats->Specialists->find('list', ['limit' => 200]);
        $this->set(compact('controlFormat', 'formatTypes', 'attentions', 'patients', 'users', 'specialists'));
        $this->set('_serialize', ['controlFormat']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Control Format id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $controlFormat = $this->ControlFormats->get($id);
        if ($this->ControlFormats->delete($controlFormat)) {
            $this->Flash->success(__('The control format has been deleted.'));
        } else {
            $this->Flash->error(__('The control format could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }



    public function save(){

        $controlFormat = $this->ControlFormats->newEntity();

        $data = $this->request->data;

        $data['users_id'] = $this->Auth->user('id');

        if(empty( $data['users_id'] )){

                 $data['users_id']  = 1;

            }
       

        $controlFormat = $this->ControlFormats->patchEntity($controlFormat, $data);
 // pr($controlFormat);
 //        exit();

        
        if ($this->ControlFormats->save($controlFormat)) {
         
            $success = true;

            $this->set(compact('success', 'controlFormat'));

        } else {

            $success = false;

            $errors = $controlFormat->errors();

            $this->set(compact('success','errors'));
            
        }

    }
}
