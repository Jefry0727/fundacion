<?php
namespace App\Controller;

use App\Controller\AppController;
//use Cake\Datasource\ConnectionManager;

/**
 * OrdersBills Controller
 *
 * @property \App\Model\Table\OrdersBillsTable $OrdersBills
 */
class OrdersBillsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['getNumberBill']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Orders', 'Bills']
        ];
        $ordersBills = $this->paginate($this->OrdersBills);

        $this->set(compact('ordersBills'));
        $this->set('_serialize', ['ordersBills']);
    }

    /**
     * Get number bill for RIP AP
     */
    
    

    /**
     * obtiene numero de factura guardada en una orden,  se utiliza para generacion de facturas.
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-11-11
     * @datetime 2016-11-11T14:01:16-0500
     * @return   [type]                   [description]
     */
    public function getNumberBill(){

        $data = $this->request->data['id'];

        $processFiles = $this->OrdersBills->find('all', ['contain'=>['Orders', 'Bills'], 
            'conditions'=>['OrdersBills.orders_id' => $data], 'fields'=>['Bills.bill_number']]);

        if($processFiles){
            $processFiles = $processFiles->toArray();
            $success = true;

            $this->set(compact('success', 'processFiles'));

        }else{

            $success = false;

            $errors = $processFiles->errors();

            $this->set(compact('success'));

        }

    }


    public function getOrderBill(){
        $data = $this->request->data['id'];

        
    }


    /**
     * View method
     *
     * @param string|null $id Orders Bill id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ordersBill = $this->OrdersBills->get($id, [
            'contain' => ['Orders', 'Bills']
        ]);

        $this->set('ordersBill', $ordersBill);
        $this->set('_serialize', ['ordersBill']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ordersBill = $this->OrdersBills->newEntity();
        if ($this->request->is('post')) {
            $ordersBill = $this->OrdersBills->patchEntity($ordersBill, $this->request->data);
            if ($this->OrdersBills->save($ordersBill)) {
                $this->Flash->success(__('The orders bill has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The orders bill could not be saved. Please, try again.'));
            }
        }
        $orders = $this->OrdersBills->Orders->find('list', ['limit' => 200]);
        $bills = $this->OrdersBills->Bills->find('list', ['limit' => 200]);
        $this->set(compact('ordersBill', 'orders', 'bills'));
        $this->set('_serialize', ['ordersBill']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Orders Bill id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ordersBill = $this->OrdersBills->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ordersBill = $this->OrdersBills->patchEntity($ordersBill, $this->request->data);
            if ($this->OrdersBills->save($ordersBill)) {
                $this->Flash->success(__('The orders bill has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The orders bill could not be saved. Please, try again.'));
            }
        }
        $orders = $this->OrdersBills->Orders->find('list', ['limit' => 200]);
        $bills = $this->OrdersBills->Bills->find('list', ['limit' => 200]);
        $this->set(compact('ordersBill', 'orders', 'bills'));
        $this->set('_serialize', ['ordersBill']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Orders Bill id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ordersBill = $this->OrdersBills->get($id);
        if ($this->OrdersBills->delete($ordersBill)) {
            $this->Flash->success(__('The orders bill has been deleted.'));
        } else {
            $this->Flash->error(__('The orders bill could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }



}
