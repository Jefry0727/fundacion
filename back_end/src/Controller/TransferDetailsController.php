<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TransferDetails Controller
 *
 * @property \App\Model\Table\TransferDetailsTable $TransferDetails
 */
class TransferDetailsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Inputs', 'Transfers']
        ];
        $transferDetails = $this->paginate($this->TransferDetails);

        $this->set(compact('transferDetails'));
        $this->set('_serialize', ['transferDetails']);
    }

    /**
     * View method
     *
     * @param string|null $id Transfer Detail id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transferDetail = $this->TransferDetails->get($id, [
            'contain' => ['Inputs', 'Transfers']
        ]);

        $this->set('transferDetail', $transferDetail);
        $this->set('_serialize', ['transferDetail']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transferDetail = $this->TransferDetails->newEntity();
        if ($this->request->is('post')) {
            $transferDetail = $this->TransferDetails->patchEntity($transferDetail, $this->request->data);
            if ($this->TransferDetails->save($transferDetail)) {
                $this->Flash->success(__('The transfer detail has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The transfer detail could not be saved. Please, try again.'));
            }
        }
        $inputs = $this->TransferDetails->Inputs->find('list', ['limit' => 200]);
        $transfers = $this->TransferDetails->Transfers->find('list', ['limit' => 200]);
        $this->set(compact('transferDetail', 'inputs', 'transfers'));
        $this->set('_serialize', ['transferDetail']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Transfer Detail id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transferDetail = $this->TransferDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transferDetail = $this->TransferDetails->patchEntity($transferDetail, $this->request->data);
            if ($this->TransferDetails->save($transferDetail)) {
                $this->Flash->success(__('The transfer detail has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The transfer detail could not be saved. Please, try again.'));
            }
        }
        $inputs = $this->TransferDetails->Inputs->find('list', ['limit' => 200]);
        $transfers = $this->TransferDetails->Transfers->find('list', ['limit' => 200]);
        $this->set(compact('transferDetail', 'inputs', 'transfers'));
        $this->set('_serialize', ['transferDetail']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Transfer Detail id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transferDetail = $this->TransferDetails->get($id);
        if ($this->TransferDetails->delete($transferDetail)) {
            $this->Flash->success(__('The transfer detail has been deleted.'));
        } else {
            $this->Flash->error(__('The transfer detail could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
