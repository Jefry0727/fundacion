<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * HabilitationCode Controller
 *
 * @property \App\Model\Table\HabilitationCodeTable $HabilitationCode
 */
class HabilitationCodeController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['getCenter']);
    }

    public function getCenter(){

        $this->loadModel('Centers');
        $centers = $this->Centers->find('all',[
            'conditions'=>[
                'state'=>1
            ]
        ]);




        if($centers){

            $success = true;

            $centers = $centers->toArray();

            $this->set(compact('success', 'centers'));
            
        }else{

            $success = false;

            if( $centers->errors() ){

                $centers = $centers->errors();

            }
            else{
                $centers = $centers->toArray();

            }

            $this->set(compact('success', 'centers'));
        }

    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Centers']
        ];
        $habilitationCode = $this->paginate($this->HabilitationCode);

        $this->set(compact('habilitationCode'));
        $this->set('_serialize', ['habilitationCode']);
    }

    /**
     * View method
     *
     * @param string|null $id Habilitation Code id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $habilitationCode = $this->HabilitationCode->get($id, [
            'contain' => ['Centers']
        ]);

        $this->set('habilitationCode', $habilitationCode);
        $this->set('_serialize', ['habilitationCode']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $habilitationCode = $this->HabilitationCode->newEntity();
        if ($this->request->is('post')) {
            $habilitationCode = $this->HabilitationCode->patchEntity($habilitationCode, $this->request->data);
            if ($this->HabilitationCode->save($habilitationCode)) {
                $this->Flash->success(__('The habilitation code has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The habilitation code could not be saved. Please, try again.'));
            }
        }
        $centers = $this->HabilitationCode->Centers->find('list', ['limit' => 200]);
        $this->set(compact('habilitationCode', 'centers'));
        $this->set('_serialize', ['habilitationCode']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Habilitation Code id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $habilitationCode = $this->HabilitationCode->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $habilitationCode = $this->HabilitationCode->patchEntity($habilitationCode, $this->request->data);
            if ($this->HabilitationCode->save($habilitationCode)) {
                $this->Flash->success(__('The habilitation code has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The habilitation code could not be saved. Please, try again.'));
            }
        }
        $centers = $this->HabilitationCode->Centers->find('list', ['limit' => 200]);
        $this->set(compact('habilitationCode', 'centers'));
        $this->set('_serialize', ['habilitationCode']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Habilitation Code id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $habilitationCode = $this->HabilitationCode->get($id);
        if ($this->HabilitationCode->delete($habilitationCode)) {
            $this->Flash->success(__('The habilitation code has been deleted.'));
        } else {
            $this->Flash->error(__('The habilitation code could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
