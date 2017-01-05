<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RipControles Controller
 *
 * @property \App\Model\Table\RipControlesTable $RipControles
 */
class RipControlesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $ripControles = $this->paginate($this->RipControles);

        $this->set(compact('ripControles'));
        $this->set('_serialize', ['ripControles']);
    }

    /**
     * View method
     *
     * @param string|null $id Rip Controle id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ripControle = $this->RipControles->get($id, [
            'contain' => []
        ]);

        $this->set('ripControle', $ripControle);
        $this->set('_serialize', ['ripControle']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ripControle = $this->RipControles->newEntity();
        if ($this->request->is('post')) {
            $ripControle = $this->RipControles->patchEntity($ripControle, $this->request->data);
            if ($this->RipControles->save($ripControle)) {
                $this->Flash->success(__('The rip controle has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rip controle could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ripControle'));
        $this->set('_serialize', ['ripControle']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rip Controle id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ripControle = $this->RipControles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ripControle = $this->RipControles->patchEntity($ripControle, $this->request->data);
            if ($this->RipControles->save($ripControle)) {
                $this->Flash->success(__('The rip controle has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rip controle could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ripControle'));
        $this->set('_serialize', ['ripControle']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rip Controle id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ripControle = $this->RipControles->get($id);
        if ($this->RipControles->delete($ripControle)) {
            $this->Flash->success(__('The rip controle has been deleted.'));
        } else {
            $this->Flash->error(__('The rip controle could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
