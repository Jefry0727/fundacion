<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Regimes Controller
 *
 * @property \App\Model\Table\RegimesTable $Regimes
 */
class RegimesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $regimes = $this->paginate($this->Regimes);

        $this->set(compact('regimes'));
        $this->set('_serialize', ['regimes']);
    }

    /**
     * View method
     *
     * @param string|null $id Regime id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $regime = $this->Regimes->get($id, [
            'contain' => []
        ]);

        $this->set('regime', $regime);
        $this->set('_serialize', ['regime']);
        return  $regime;
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $regime = $this->Regimes->newEntity();
        if ($this->request->is('post')) {
            $regime = $this->Regimes->patchEntity($regime, $this->request->data);
            if ($this->Regimes->save($regime)) {
                $this->Flash->success(__('The regime has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The regime could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('regime'));
        $this->set('_serialize', ['regime']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Regime id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $regime = $this->Regimes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $regime = $this->Regimes->patchEntity($regime, $this->request->data);
            if ($this->Regimes->save($regime)) {
                $this->Flash->success(__('The regime has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The regime could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('regime'));
        $this->set('_serialize', ['regime']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Regime id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $regime = $this->Regimes->get($id);
        if ($this->Regimes->delete($regime)) {
            $this->Flash->success(__('The regime has been deleted.'));
        } else {
            $this->Flash->error(__('The regime could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
