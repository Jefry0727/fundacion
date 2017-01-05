<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OutputsDetails Controller
 *
 * @property \App\Model\Table\OutputsDetailsTable $OutputsDetails
 */
class OutputsDetailsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['StorageUbications', 'Units', 'Products', 'Outputs']
        ];
        $outputsDetails = $this->paginate($this->OutputsDetails);

        $this->set(compact('outputsDetails'));
        $this->set('_serialize', ['outputsDetails']);
    }

    /**
     * View method
     *
     * @param string|null $id Outputs Detail id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $outputsDetail = $this->OutputsDetails->get($id, [
            'contain' => ['StorageUbications', 'Units', 'Products', 'Outputs']
        ]);

        $this->set('outputsDetail', $outputsDetail);
        $this->set('_serialize', ['outputsDetail']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $outputsDetail = $this->OutputsDetails->newEntity();
        if ($this->request->is('post')) {
            $outputsDetail = $this->OutputsDetails->patchEntity($outputsDetail, $this->request->data);
            if ($this->OutputsDetails->save($outputsDetail)) {
                $this->Flash->success(__('The outputs detail has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The outputs detail could not be saved. Please, try again.'));
            }
        }
        $storageUbications = $this->OutputsDetails->StorageUbications->find('list', ['limit' => 200]);
        $units = $this->OutputsDetails->Units->find('list', ['limit' => 200]);
        $products = $this->OutputsDetails->Products->find('list', ['limit' => 200]);
        $outputs = $this->OutputsDetails->Outputs->find('list', ['limit' => 200]);
        $this->set(compact('outputsDetail', 'storageUbications', 'units', 'products', 'outputs'));
        $this->set('_serialize', ['outputsDetail']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Outputs Detail id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $outputsDetail = $this->OutputsDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $outputsDetail = $this->OutputsDetails->patchEntity($outputsDetail, $this->request->data);
            if ($this->OutputsDetails->save($outputsDetail)) {
                $this->Flash->success(__('The outputs detail has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The outputs detail could not be saved. Please, try again.'));
            }
        }
        $storageUbications = $this->OutputsDetails->StorageUbications->find('list', ['limit' => 200]);
        $units = $this->OutputsDetails->Units->find('list', ['limit' => 200]);
        $products = $this->OutputsDetails->Products->find('list', ['limit' => 200]);
        $outputs = $this->OutputsDetails->Outputs->find('list', ['limit' => 200]);
        $this->set(compact('outputsDetail', 'storageUbications', 'units', 'products', 'outputs'));
        $this->set('_serialize', ['outputsDetail']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Outputs Detail id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $outputsDetail = $this->OutputsDetails->get($id);
        if ($this->OutputsDetails->delete($outputsDetail)) {
            $this->Flash->success(__('The outputs detail has been deleted.'));
        } else {
            $this->Flash->error(__('The outputs detail could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
