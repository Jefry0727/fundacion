<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BusinessTerms Controller
 *
 * @property \App\Model\Table\BusinessTermsTable $BusinessTerms
 */
class BusinessTermsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $businessTerms = $this->paginate($this->BusinessTerms);

        $this->set(compact('businessTerms'));
        $this->set('_serialize', ['businessTerms']);
    }

    /**
     * View method
     *
     * @param string|null $id Business Term id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $businessTerm = $this->BusinessTerms->get($id, [
            'contain' => []
        ]);

        $this->set('businessTerm', $businessTerm);
        $this->set('_serialize', ['businessTerm']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $businessTerm = $this->BusinessTerms->newEntity();

        if ($this->request->is('post')) {
        
            $businessTerm = $this->BusinessTerms->patchEntity($businessTerm, $this->request->data);
        
            if ($this->BusinessTerms->save($businessTerm)) {
        
                $this->Flash->success(__('The business term has been saved.'));
        
                return $this->redirect(['action' => 'index']);
        
            } else {
        
                $this->Flash->error(__('The business term could not be saved. Please, try again.'));
        
            }
        
        }
        
        $this->set(compact('businessTerm'));
        
        $this->set('_serialize', ['businessTerm']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Business Term id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $businessTerm = $this->BusinessTerms->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
        
            $businessTerm = $this->BusinessTerms->patchEntity($businessTerm, $this->request->data);
        
            if ($this->BusinessTerms->save($businessTerm)) {
        
                $this->Flash->success(__('The business term has been saved.'));
        
                return $this->redirect(['action' => 'index']);
        
            } else {
        
                $this->Flash->error(__('The business term could not be saved. Please, try again.'));
            }
        }
        
        $this->set(compact('businessTerm'));
        
        $this->set('_serialize', ['businessTerm']);
    }

    /**
     * Delete method
     *
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $businessTerm = $this->BusinessTerms->get($id);
        if ($this->BusinessTerms->delete($businessTerm)) {
            $this->Flash->success(__('The business term has been deleted.'));
        } else {
            $this->Flash->error(__('The business term could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }



}
