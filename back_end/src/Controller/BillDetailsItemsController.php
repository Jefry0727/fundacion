<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BillDetailsItems Controller
 *
 * @property \App\Model\Table\BillDetailsItemsTable $BillDetailsItems
 */
class BillDetailsItemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Items', 'BillDetails', 'ItemTypes']
        ];
        $billDetailsItems = $this->paginate($this->BillDetailsItems);

        $this->set(compact('billDetailsItems'));
        $this->set('_serialize', ['billDetailsItems']);
    }

    /**
     * View method
     *
     * @param string|null $id Bill Details Item id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $billDetailsItem = $this->BillDetailsItems->get($id, [
            'contain' => ['Items', 'BillDetails', 'ItemTypes']
        ]);

        $this->set('billDetailsItem', $billDetailsItem);
        $this->set('_serialize', ['billDetailsItem']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $billDetailsItem = $this->BillDetailsItems->newEntity();
        if ($this->request->is('post')) {
            $billDetailsItem = $this->BillDetailsItems->patchEntity($billDetailsItem, $this->request->data);
            if ($this->BillDetailsItems->save($billDetailsItem)) {
                $this->Flash->success(__('The bill details item has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bill details item could not be saved. Please, try again.'));
            }
        }
        $items = $this->BillDetailsItems->Items->find('list', ['limit' => 200]);
        $billDetails = $this->BillDetailsItems->BillDetails->find('list', ['limit' => 200]);
        $itemTypes = $this->BillDetailsItems->ItemTypes->find('list', ['limit' => 200]);
        $this->set(compact('billDetailsItem', 'items', 'billDetails', 'itemTypes'));
        $this->set('_serialize', ['billDetailsItem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Bill Details Item id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $billDetailsItem = $this->BillDetailsItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $billDetailsItem = $this->BillDetailsItems->patchEntity($billDetailsItem, $this->request->data);
            if ($this->BillDetailsItems->save($billDetailsItem)) {
                $this->Flash->success(__('The bill details item has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bill details item could not be saved. Please, try again.'));
            }
        }
        $items = $this->BillDetailsItems->Items->find('list', ['limit' => 200]);
        $billDetails = $this->BillDetailsItems->BillDetails->find('list', ['limit' => 200]);
        $itemTypes = $this->BillDetailsItems->ItemTypes->find('list', ['limit' => 200]);
        $this->set(compact('billDetailsItem', 'items', 'billDetails', 'itemTypes'));
        $this->set('_serialize', ['billDetailsItem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Bill Details Item id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $billDetailsItem = $this->BillDetailsItems->get($id);
        if ($this->BillDetailsItems->delete($billDetailsItem)) {
            $this->Flash->success(__('The bill details item has been deleted.'));
        } else {
            $this->Flash->error(__('The bill details item could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
