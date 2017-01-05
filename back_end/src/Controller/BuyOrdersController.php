<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BuyOrders Controller
 *
 * @property \App\Model\Table\BuyOrdersTable $BuyOrders
 */
class BuyOrdersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Providers']
        ];
        $buyOrders = $this->paginate($this->BuyOrders);

        $this->set(compact('buyOrders'));
        $this->set('_serialize', ['buyOrders']);
    }

    /**
     * View method
     *
     * @param string|null $id Buy Order id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $buyOrder = $this->BuyOrders->get($id, [
            'contain' => ['Users', 'Providers']
        ]);

        $this->set('buyOrder', $buyOrder);
        $this->set('_serialize', ['buyOrder']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $buyOrder = $this->BuyOrders->newEntity();
        if ($this->request->is('post')) {
            $buyOrder = $this->BuyOrders->patchEntity($buyOrder, $this->request->data);
            if ($this->BuyOrders->save($buyOrder)) {
                $this->Flash->success(__('The buy order has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The buy order could not be saved. Please, try again.'));
            }
        }
        $users = $this->BuyOrders->Users->find('list', ['limit' => 200]);
        $providers = $this->BuyOrders->Providers->find('list', ['limit' => 200]);
        $this->set(compact('buyOrder', 'users', 'providers'));
        $this->set('_serialize', ['buyOrder']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Buy Order id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $buyOrder = $this->BuyOrders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $buyOrder = $this->BuyOrders->patchEntity($buyOrder, $this->request->data);
            if ($this->BuyOrders->save($buyOrder)) {
                $this->Flash->success(__('The buy order has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The buy order could not be saved. Please, try again.'));
            }
        }
        $users = $this->BuyOrders->Users->find('list', ['limit' => 200]);
        $providers = $this->BuyOrders->Providers->find('list', ['limit' => 200]);
        $this->set(compact('buyOrder', 'users', 'providers'));
        $this->set('_serialize', ['buyOrder']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Buy Order id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $buyOrder = $this->BuyOrders->get($id);
        if ($this->BuyOrders->delete($buyOrder)) {
            $this->Flash->success(__('The buy order has been deleted.'));
        } else {
            $this->Flash->error(__('The buy order could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
