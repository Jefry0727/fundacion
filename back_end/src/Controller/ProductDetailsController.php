<?php
namespace App\Controller;

use App\Controller\AppController;


/**
 * ProductDetails Controller
 *
 * @property \App\Model\Table\ProductDetailsTable $ProductDetails
 */
class ProductDetailsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products', 'Providers', 'Marks', 'Units', 'InvimaCodes']
        ];
        $productDetails = $this->paginate($this->ProductDetails);

        $this->set(compact('productDetails'));
        $this->set('_serialize', ['productDetails']);
    }

    /**
     * View method
     *
     * @param string|null $id Product Detail id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productDetail = $this->ProductDetails->get($id, [
            'contain' => ['Products', 'Providers', 'Marks', 'Units', 'InvimaCodes']
        ]);

        $this->set('productDetail', $productDetail);
        $this->set('_serialize', ['productDetail']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productDetail = $this->ProductDetails->newEntity();
        if ($this->request->is('post')) {
            $productDetail = $this->ProductDetails->patchEntity($productDetail, $this->request->data);
            if ($this->ProductDetails->save($productDetail)) {
                $this->Flash->success(__('The product detail has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The product detail could not be saved. Please, try again.'));
            }
        }
        $products = $this->ProductDetails->Products->find('list', ['limit' => 200]);
        $providers = $this->ProductDetails->Providers->find('list', ['limit' => 200]);
        $marks = $this->ProductDetails->Marks->find('list', ['limit' => 200]);
        $units = $this->ProductDetails->Units->find('list', ['limit' => 200]);
        $invimaCodes = $this->ProductDetails->InvimaCodes->find('list', ['limit' => 200]);
        $this->set(compact('productDetail', 'products', 'providers', 'marks', 'units', 'invimaCodes'));
        $this->set('_serialize', ['productDetail']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Detail id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productDetail = $this->ProductDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productDetail = $this->ProductDetails->patchEntity($productDetail, $this->request->data);
            if ($this->ProductDetails->save($productDetail)) {
                $this->Flash->success(__('The product detail has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The product detail could not be saved. Please, try again.'));
            }
        }
        $products = $this->ProductDetails->Products->find('list', ['limit' => 200]);
        $providers = $this->ProductDetails->Providers->find('list', ['limit' => 200]);
        $marks = $this->ProductDetails->Marks->find('list', ['limit' => 200]);
        $units = $this->ProductDetails->Units->find('list', ['limit' => 200]);
        $invimaCodes = $this->ProductDetails->InvimaCodes->find('list', ['limit' => 200]);
        $this->set(compact('productDetail', 'products', 'providers', 'marks', 'units', 'invimaCodes'));
        $this->set('_serialize', ['productDetail']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Detail id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productDetail = $this->ProductDetails->get($id);
        if ($this->ProductDetails->delete($productDetail)) {
            $this->Flash->success(__('The product detail has been deleted.'));
        } else {
            $this->Flash->error(__('The product detail could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    public function getDetailsByProduct(){

        $data =  $this->request->data;

        $products = $this->ProductDetails->find('all',
            ['contain'=>['InvimaCodes'],
             'conditions'=>['ProductDetails.products_id'=>$data['id']]
            
            ]
             )->toArray();

        if($products)

        {
            $success = true;

            $this->set(compact('success', 'products'));

        }else{

            $this->set(compact('success'));

        }
    }


    /**
     * Obtiene todos los detalles de productos
     * @return [type] [description]
     */
    public function getAllProductsDetails(){

        $data =  $this->request->data;

        $products = $this->ProductDetails->find('all');

        if($products)

        {
            $success = true;

            $this->set(compact('success', 'products'));

        }else{

            $this->set(compact('success'));

        }

    }
    /**
     * adiciona un producto derails
     * @param [type] $data [description]
     */
    public function addProductDetails(){

            $data = $this->request->data;

          
            $productDetails = $this->ProductDetails->newEntity();

            $productDetails = $this->ProductDetails->patchEntity($productDetails, $data);

            if ($this->ProductDetails->save($productDetails)) {

                $success = true;

                $this->set(compact('success', 'productDetails'));

            } else {
              
              $success = false;
      
              $error = $productDetails->errors();

              $this->set(compact('success','error'));

            }

    }
//expiration_date, lot, temp_store, order_code, products_id, providers_id, marks_id, units_id, invima_codes_id, total
  
    /**
     * Valida si ya existe un detalle de producto.
     * @return [type] [description]
     */
    public function existProduct(){

        $data = $this->request->data;
        
        $productDetails = $this->ProductDetails->find('all',
            ['conditions'=>[
                'ProductDetails.products_id' => $data['products_id'],
                'ProductDetails.marks_id' =>$data['marks_id'],
                'ProductDetails.units_id' =>$data['units_id'],

                ]
            ]
        )->first();


            if($productDetails){

                $success = true;

                $this->set(compact('success', 'productDetails'));
            
            }else{
            
                $success = false;
                
                $this->set(compact('success'));
            } 
  }


    
}
