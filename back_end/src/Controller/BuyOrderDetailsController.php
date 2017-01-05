<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BuyOrderDetails Controller
 *
 * @property \App\Model\Table\BuyOrderDetailsTable $BuyOrderDetails
 */
class BuyOrderDetailsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['BuyOrders', 'Products']
        ];
        $buyOrderDetails = $this->paginate($this->BuyOrderDetails);

        $this->set(compact('buyOrderDetails'));
        $this->set('_serialize', ['buyOrderDetails']);
    }

    /**
     * View method
     *
     * @param string|null $id Buy Order Detail id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $buyOrderDetail = $this->BuyOrderDetails->get($id, [
            'contain' => ['BuyOrders', 'Products']
        ]);

        $this->set('buyOrderDetail', $buyOrderDetail);
        $this->set('_serialize', ['buyOrderDetail']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $buyOrderDetail = $this->BuyOrderDetails->newEntity();
        if ($this->request->is('post')) {
            $buyOrderDetail = $this->BuyOrderDetails->patchEntity($buyOrderDetail, $this->request->data);
            if ($this->BuyOrderDetails->save($buyOrderDetail)) {
                $this->Flash->success(__('The buy order detail has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The buy order detail could not be saved. Please, try again.'));
            }
        }
        $buyOrders = $this->BuyOrderDetails->BuyOrders->find('list', ['limit' => 200]);
        $products = $this->BuyOrderDetails->Products->find('list', ['limit' => 200]);
        $this->set(compact('buyOrderDetail', 'buyOrders', 'products'));
        $this->set('_serialize', ['buyOrderDetail']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Buy Order Detail id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $buyOrderDetail = $this->BuyOrderDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $buyOrderDetail = $this->BuyOrderDetails->patchEntity($buyOrderDetail, $this->request->data);
            if ($this->BuyOrderDetails->save($buyOrderDetail)) {
                $this->Flash->success(__('The buy order detail has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The buy order detail could not be saved. Please, try again.'));
            }
        }
        $buyOrders = $this->BuyOrderDetails->BuyOrders->find('list', ['limit' => 200]);
        $products = $this->BuyOrderDetails->Products->find('list', ['limit' => 200]);
        $this->set(compact('buyOrderDetail', 'buyOrders', 'products'));
        $this->set('_serialize', ['buyOrderDetail']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Buy Order Detail id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $buyOrderDetail = $this->BuyOrderDetails->get($id);
        if ($this->BuyOrderDetails->delete($buyOrderDetail)) {
            $this->Flash->success(__('The buy order detail has been deleted.'));
        } else {
            $this->Flash->error(__('The buy order detail could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
