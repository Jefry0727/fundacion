<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{
    /**
     * [initialize description]
     * @return [type] [description]
     */
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['allProducts', 'add', 'edit','searchProducts','getProducts']);

    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Section']
        ];
        $products = $this->paginate($this->Products);

        $this->set(compact('products'));
        $this->set('_serialize', ['products']);
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => ['Section', 'Studies', 'InvimaCodes']
        ]);

        $this->set('product', $product);
        $this->set('_serialize', ['product']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEntity();
    
            $product = $this->Products->patchEntity($product, $this->request->data);

            if ($this->Products->save($product)) {

                $success = true;

                $this->set(compact('success', 'Product'));
               
            } else {

                $success = false;

                $this->set(compact('success'));
               
            }
        
       
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $id = $this->request->data['id'];

        $product = $this->Products->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $product = $this->Products->patchEntity($product, $this->request->data);

            if ($this->Products->save($product)) {

                $success = true;

                $this->set(compact('success', 'product'));

            } else {
                
                $success = false;

                $this->set(compact('success'));
            }
        }
        
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function allProducts()
    {
        $data = $this->request->data;

        $offset = $data['offset'];

        $products = $this->Products->find('all', ['limit' => 10, 'offset' => $offset]);

        $total = $this->Products->find('all')->count();


        if($products)
        {
            $success = true;

            $this->set(compact('success', 'products', 'total'));

        }else{

            $success = false;

            $this->set(compact('success'));
        }


    }

    /**
     * Obtiene todos los productos independiente si existen deralles o no.
     * @return [type] [description]
     */
    public function getProducts( $page = null ){

        if( empty( $page ) ){
            $products = $this->Products->find('all',['contain' =>['FarmaseuticForm']]);
        }
        else{
            $products = $this->Products->find('all',['contain' =>['FarmaseuticForm']])->limit( 20 )->page( $page );
        }

        

        if($products)
        {

            $products = $products->toArray();
            $success = true;

            $this->set(compact('success', 'products'));

        }else{

            $success = false;

            $this->set(compact('success'));
        }

    }


     // Buscar Productos... 
    public function searchProducts($bodega,$term)
    {        
        $this->autoRender = false;

        $this->loadModel('ProductsDetails');


        $term = trim($term);
        // $product = $this->Products->find('all', 
        //     ['conditions'=>["CONCAT(Products.cup,Products.name) like '%".$term."%'",
        //         "Products.state"=>1]]);
        
         $conn = ConnectionManager::get('default');

        $query = $conn->execute("
        SELECT 
                    products.id as product_id,
                    products.cup as product_cup,
                    products.name as product_name,
                    storage_inputs.single_value as product_value,
                    0 as quantity,
                    0 as total
                FROM products 
                    left join product_details on products.id = product_details.products_id
                    left join storage_inputs on storage_inputs.product_details_id = product_details.id
                    where product_details.id is not null 
                        and storage_inputs.id is not null 
                        and products.state > 0 
                        and storage_inputs.remaining >0
                        and storage_inputs.storage_ubications_id  = ".$bodega."
                        and products.name LIKE'%".$term."%'
                        group by 1,2,3,4
                        order by 3; ")->fetchAll('assoc'); 

             //and concat(products.cup,products.name) LIKE'%".$term."'
           
      $product= [];
      foreach ($query as $row) {    
               // pr($row);

                array_push($product, $row);
        }


        echo json_encode(Array('services'=>$query));

        // $this->set(compact('services'));
    }
}
