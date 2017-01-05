<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AttentionStudies Controller
 *
 * @property \App\Model\Table\AttentionStudiesTable $AttentionStudies
 */
class AttentionStudiesController extends AppController
{

     public function initialize()
    {
        
        parent::initialize();
        $this->Auth->allow(['getAttentionStudies']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Orders']
        ];
        $attentionStudies = $this->paginate($this->AttentionStudies);

        $this->set(compact('attentionStudies'));
        $this->set('_serialize', ['attentionStudies']);
    }

    /**
     * View method
     *
     * @param string|null $id Attention Study id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $attentionStudy = $this->AttentionStudies->get($id, [
            'contain' => ['Users', 'Orders']
        ]);

        $this->set('attentionStudy', $attentionStudy);
        $this->set('_serialize', ['attentionStudy']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $attentionStudy = $this->AttentionStudies->newEntity();
        if ($this->request->is('post')) {
            $attentionStudy = $this->AttentionStudies->patchEntity($attentionStudy, $this->request->data);
            if ($this->AttentionStudies->save($attentionStudy)) {
                $this->Flash->success(__('The attention study has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The attention study could not be saved. Please, try again.'));
            }
        }
        $users = $this->AttentionStudies->Users->find('list', ['limit' => 200]);
        $orders = $this->AttentionStudies->Orders->find('list', ['limit' => 200]);
        $this->set(compact('attentionStudy', 'users', 'orders'));
        $this->set('_serialize', ['attentionStudy']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Attention Study id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $attentionStudy = $this->AttentionStudies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attentionStudy = $this->AttentionStudies->patchEntity($attentionStudy, $this->request->data);
            if ($this->AttentionStudies->save($attentionStudy)) {
                $this->Flash->success(__('The attention study has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The attention study could not be saved. Please, try again.'));
            }
        }
        $users = $this->AttentionStudies->Users->find('list', ['limit' => 200]);
        $orders = $this->AttentionStudies->Orders->find('list', ['limit' => 200]);
        $this->set(compact('attentionStudy', 'users', 'orders'));
        $this->set('_serialize', ['attentionStudy']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Attention Study id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attentionStudy = $this->AttentionStudies->get($id);
        if ($this->AttentionStudies->delete($attentionStudy)) {
            $this->Flash->success(__('The attention study has been deleted.'));
        } else {
            $this->Flash->error(__('The attention study could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

      public function getAttentionStudies(){



        $data = $this->request->data;
        
        
        $offset = $data['offset'];

        $attentionStudy = $this->AttentionStudies->find('all', ['limit' => 10,'offset'=> $offset]);

        $attentionStudyTotal = $this->AttentionStudies->find('all')->count();
        
        if ($attentionStudy) {
        
            $success = true;

            $this->set(compact('success','attentionStudy','attentionStudyTotal'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }


    }
}
