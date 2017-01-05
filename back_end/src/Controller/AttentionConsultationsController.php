<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AttentionConsultations Controller
 *
 * @property \App\Model\Table\AttentionConsultationsTable $AttentionConsultations
 */
class AttentionConsultationsController extends AppController
{

     public function initialize()
    {
        
        parent::initialize();
        $this->Auth->allow(['getAttentionConsultations']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Orders', 'Specialists']
        ];
        $attentionConsultations = $this->paginate($this->AttentionConsultations);

        $this->set(compact('attentionConsultations'));
        $this->set('_serialize', ['attentionConsultations']);
    }

    /**
     * View method
     */
    public function view($id = null)
    {
        $attentionConsultation = $this->AttentionConsultations->get($id, [
            'contain' => ['Orders', 'Specialists']
        ]);

        $this->set('attentionConsultation', $attentionConsultation);
        $this->set('_serialize', ['attentionConsultation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $attentionConsultation = $this->AttentionConsultations->newEntity();
        if ($this->request->is('post')) {
            $attentionConsultation = $this->AttentionConsultations->patchEntity($attentionConsultation, $this->request->data);
            if ($this->AttentionConsultations->save($attentionConsultation)) {
                $this->Flash->success(__('The attention consultation has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The attention consultation could not be saved. Please, try again.'));
            }
        }
        $orders = $this->AttentionConsultations->Orders->find('list', ['limit' => 200]);
        $specialists = $this->AttentionConsultations->Specialists->find('list', ['limit' => 200]);
        $this->set(compact('attentionConsultation', 'orders', 'specialists'));
        $this->set('_serialize', ['attentionConsultation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Attention Consultation id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     */
    public function edit($id = null)
    {
        $attentionConsultation = $this->AttentionConsultations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attentionConsultation = $this->AttentionConsultations->patchEntity($attentionConsultation, $this->request->data);
            if ($this->AttentionConsultations->save($attentionConsultation)) {
                $this->Flash->success(__('The attention consultation has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The attention consultation could not be saved. Please, try again.'));
            }
        }
        $orders = $this->AttentionConsultations->Orders->find('list', ['limit' => 200]);
        $specialists = $this->AttentionConsultations->Specialists->find('list', ['limit' => 200]);
        $this->set(compact('attentionConsultation', 'orders', 'specialists'));
        $this->set('_serialize', ['attentionConsultation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Attention Consultation id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attentionConsultation = $this->AttentionConsultations->get($id);
        if ($this->AttentionConsultations->delete($attentionConsultation)) {
            $this->Flash->success(__('The attention consultation has been deleted.'));
        } else {
            $this->Flash->error(__('The attention consultation could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    
    
    public function getAttentionConsultations(){



        $data = $this->request->data;
        
        
        $offset = $data['offset'];

        $attentionConsultations = $this->AttentionConsultations->find('all', ['limit' => 10,'offset'=> $offset]);

        $attentionConsultationsTotal = $this->AttentionConsultations->find('all')->count();
        
        if ($attentionConsultations) {
        
            $success = true;

            $this->set(compact('success','attentionConsultations','attentionConsultationsTotal'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }


    }
}
