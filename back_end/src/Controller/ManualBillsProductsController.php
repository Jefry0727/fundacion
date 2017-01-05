<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ManualBillsProducts Controller
 *
 * @property \App\Model\Table\ManualBillsProductsTable $ManualBillsProducts
 */
class ManualBillsProductsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
        'contain' => ['ManualBills', 'Products']
        ];
        $manualBillsProducts = $this->paginate($this->ManualBillsProducts);

        $this->set(compact('manualBillsProducts'));
        $this->set('_serialize', ['manualBillsProducts']);
    }

    /**
     * View method
     *
     * @param string|null $id Manual Bills Product id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $manualBillsProduct = $this->ManualBillsProducts->get($id, [
            'contain' => ['ManualBills', 'Products']
            ]);

        $this->set('manualBillsProduct', $manualBillsProduct);
        $this->set('_serialize', ['manualBillsProduct']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $manualBillsProduct = $this->ManualBillsProducts->newEntity();
        if ($this->request->is('post')) {
            $manualBillsProduct = $this->ManualBillsProducts->patchEntity($manualBillsProduct, $this->request->data);
            if ($this->ManualBillsProducts->save($manualBillsProduct)) {
                $this->Flash->success(__('The manual bills product has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The manual bills product could not be saved. Please, try again.'));
            }
        }
        $manualBills = $this->ManualBillsProducts->ManualBills->find('list', ['limit' => 200]);
        $products = $this->ManualBillsProducts->Products->find('list', ['limit' => 200]);
        $this->set(compact('manualBillsProduct', 'manualBills', 'products'));
        $this->set('_serialize', ['manualBillsProduct']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Manual Bills Product id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $manualBillsProduct = $this->ManualBillsProducts->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $manualBillsProduct = $this->ManualBillsProducts->patchEntity($manualBillsProduct, $this->request->data);
            if ($this->ManualBillsProducts->save($manualBillsProduct)) {
                $this->Flash->success(__('The manual bills product has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The manual bills product could not be saved. Please, try again.'));
            }
        }
        $manualBills = $this->ManualBillsProducts->ManualBills->find('list', ['limit' => 200]);
        $products = $this->ManualBillsProducts->Products->find('list', ['limit' => 200]);
        $this->set(compact('manualBillsProduct', 'manualBills', 'products'));
        $this->set('_serialize', ['manualBillsProduct']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Manual Bills Product id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $manualBillsProduct = $this->ManualBillsProducts->get($id);
        if ($this->ManualBillsProducts->delete($manualBillsProduct)) {
            $this->Flash->success(__('The manual bills product has been deleted.'));
        } else {
            $this->Flash->error(__('The manual bills product could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    public function saveProduct(){

        $data = $this->request->data;

        unset($data['center']);

        $billId = $data['id'];
        $services = $data['services'];

        $item = array();

        foreach ($services as $value) {
           // id, quantity, manual_bills_id, products_id, total

            $item['quantity'] = $value['quantity'];
            $item['manual_bills_id'] = $billId;
            $item['products_id'] = $value['product_id'];
            $item['total'] = $value['total'];

            $billProducts = $this->ManualBillsProducts->newEntity();

            $billProducts = $this->ManualBillsProducts->patchEntity($billProducts, $item);

            if ($this->ManualBillsProducts->save($billProducts)) {

                $success = true;

            } else {

                $errors = $billProducts->errors();

                $success = false;
            
            }


        }
           $this->set( compact( 'success', 'errors' ) );

    }
}
