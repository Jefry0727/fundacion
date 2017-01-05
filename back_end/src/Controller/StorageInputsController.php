<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * StorageInputs Controller
 *
 * @property \App\Model\Table\StorageInputsTable $StorageInputs
 */
class StorageInputsController extends AppController
{


  public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['productReasume','getAllStorageInputs','getStorageProduct','updateInputQuote']);
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['StorageUbications', 'ProductDetails']
        ];
        $storageInputs = $this->paginate($this->StorageInputs);

        $this->set(compact('storageInputs'));
        $this->set('_serialize', ['storageInputs']);
    }

    /**
     * View method
     *
     * @param string|null $id Storage Input id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $storageInput = $this->StorageInputs->get($id, [
            'contain' => ['StorageUbications', 'ProductDetails']
        ]);

        $this->set('storageInput', $storageInput);
        $this->set('_serialize', ['storageInput']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $storageInput = $this->StorageInputs->newEntity();
        if ($this->request->is('post')) {
            $storageInput = $this->StorageInputs->patchEntity($storageInput, $this->request->data);
            if ($this->StorageInputs->save($storageInput)) {
                $this->Flash->success(__('The storage input has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The storage input could not be saved. Please, try again.'));
            }
        }
        $storageUbications = $this->StorageInputs->StorageUbications->find('list', ['limit' => 200]);
        $productDetails = $this->StorageInputs->ProductDetails->find('list', ['limit' => 200]);
        $this->set(compact('storageInput', 'storageUbications', 'productDetails'));
        $this->set('_serialize', ['storageInput']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Storage Input id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $storageInput = $this->StorageInputs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $storageInput = $this->StorageInputs->patchEntity($storageInput, $this->request->data);
            if ($this->StorageInputs->save($storageInput)) {
                $this->Flash->success(__('The storage input has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The storage input could not be saved. Please, try again.'));
            }
        }
        $storageUbications = $this->StorageInputs->StorageUbications->find('list', ['limit' => 200]);
        $productDetails = $this->StorageInputs->ProductDetails->find('list', ['limit' => 200]);
        $this->set(compact('storageInput', 'storageUbications', 'productDetails'));
        $this->set('_serialize', ['storageInput']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Storage Input id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $storageInput = $this->StorageInputs->get($id);
        if ($this->StorageInputs->delete($storageInput)) {
            $this->Flash->success(__('The storage input has been deleted.'));
        } else {
            $this->Flash->error(__('The storage input could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }



    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addInputs()
    {
          $data = $this->request->data;
          $data['users_id'] = $this->Auth->user('id');
          $data['created']  = date( 'Y-m-d H:i:s' );
          $data['modified']  = date( 'Y-m-d H:i:s' );

         $input = $this->StorageInputs->newEntity();

            $input = $this->StorageInputs->patchEntity($input, $data);

            if ($this->StorageInputs->save($input)) {
                 $success = true;

                $this->set(compact('success','input'));
                
            } else {

                    $success = false;

                 $error = $input->errors();

                $this->set(compact('success','error'));

                
            }
    }

    public function getInputProduct(){

        $data = $this->request->data;

        $idProducts = $data['idProduct'];

        $idStorage = $data['idStorage'];

        $inputs =  $this->StorageInputs->find('all',[

            'contain' => ['StorageUbications', 'Users'],

            'conditions'=> [

              "Inputs.products_id = '".$idProducts."'",

              "Inputs.storage_ubications_id = '".$idStorage."'",

            ]

        ])->first(); 


      $success = true;


      $this->set(compact('success','inputs'));

    }

    public function getAllInputs(){

        $inputs = $this->StorageInputs->find('all',
                ['contain'=>[
                    'StorageUbications', 
                    'ProductDetails.Products',
                    'ProductDetails.Marks',
                    'ProductDetails.Units'],
                    ]);
        // $inputs = $inputs->select(
        //         [   'Storage' =>'StorageUbications.name',
        //             'Code' => 'ProductDetails.Products.cup',
        //             'Name'=> 'ProductDetails.Products.name',
        //             'Mark' => 'ProductDetails.Marks.name',
        //             'Ingresos' => ('StorageInputs.quant_input'),
        //             'Salidas' => ('StorageInputs.remaining'),
        //         ]);         

        // $inputs = $inputs->group([1,2,3,4])->toArray();

        if($inputs){
             $success = true;

             $this->set(compact('success','inputs'));

        }else{
            $success = false;

            $this->set(compact('success'));
        }

    }

    public function updateInputQuote(){

        $conn = ConnectionManager::get('default');

        $data = $this->request->data;

        $items = $data['items'];
        
        
        for ($i=0; $i < count($data); $i++) { 

          if($items[$i]['transfer_id'] == ''){
                $query = $conn->execute('
                UPDATE storage_inputs SET remaining ='.$items[$i]['equal'].' 
                WHERE id ='.$items[$i]['inputs_id']); 
          }else{
                $query = $conn->execute('
                UPDATE transfer_details SET quant_output ='.$items[$i]['remaining'].' 
                WHERE id ='.$items[$i]['transfer_id']);
          }
          $this->set(compact('query'));
          
        }

          

        }
    /**
     * GET ALL PRODUCTOS IN STORAGE, THAT HAVE REMAININGS.
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-09-13
     * @datetime 2016-09-13T08:41:36-0500
     * @return   [type]                   [description]
     */
    public function getAllStorageInputs(){

        $conn = ConnectionManager::get('default');

        $data =  $this->request->data;

        $query = $conn->execute('
          SELECT pd.id,p.name AS name_product,pd.id,m.name AS mark , st.remaining
            FROM storage_inputs AS st
              INNER JOIN product_details AS pd ON st.product_details_id = pd.id
              INNER JOIN products AS p ON pd.products_id = p.id
              INNER JOIN marks AS m ON pd.marks_id = m.id
              INNER JOIN storage_ubications AS su ON st.storage_ubications_id = su.id
              WHERE st.storage_ubications_id = '.$data['id'].'
                 AND   st.remaining >0
          UNION 
          SELECT pd.id,p.name AS name_product,pd.id,m.name AS mark,  st.remaining 
            FROM transfer_details  AS td
              INNER JOIN storage_inputs AS st ON td.storage_inputs_id = st.id
              INNER JOIN product_details AS pd ON td.product_details_id = pd.id
              INNER JOIN products AS p ON pd.products_id = p.id
              INNER JOIN marks AS m ON pd.marks_id = m.id
              INNER JOIN storage_ubications AS su ON td.storage_ubications_id = su.id
              WHERE   st.remaining >0 
                AND td.storage_ubications_id ='.$data['id'])->fetchAll('assoc'); 

          // pr($query);
         


      //   pr($List);

        // for ($i=0; $i < count($StorageInputs); $i++) { 

        //         $storageData[] = Array(

        //             'id' => $StorageInputs[$i]['product_detail']['id'],
        //             'mark' => $StorageInputs[$i]['product_detail']['mark']['name'],
        //             'name_product' => $StorageInputs[$i]['product_detail']['product']['name']

        //         );

        //     }

          $this->set(compact('query'));

    }

    /**
     * Get all the quantity for product available in storage. 
     * @author Deicy Rojas <deirojas.1@gmail.com>
     */
    public function getStorageProduct(){

         $conn = ConnectionManager::get('default');

          $data =  $this->request->data;

          $query = $conn->execute('
            SELECT pd.id AS product_details_id,p.name AS name_product,m.name AS mark,pd.lot,u.name AS units,pr.name AS providers,i.code AS invima_codes,st.remaining, su.name AS storage_name,su.id AS storage_id, st.id AS storage_inputs_id , null AS transfer_id FROM storage_inputs AS st
            INNER JOIN product_details AS pd ON st.product_details_id = pd.id
            INNER JOIN products AS p ON pd.products_id = p.id
            INNER JOIN marks AS m ON pd.marks_id = m.id
            INNER JOIN providers AS pr ON pd.providers_id = pr.id
            INNER JOIN units AS u ON pd.units_id = u.id
            INNER JOIN invima_codes AS i ON pd.invima_codes_id = i.id
            INNER JOIN storage_ubications AS su ON st.storage_ubications_id = su.id
           WHERE  st.remaining > 0
                AND st.storage_ubications_id ='.$data['idStorage'].' 
                AND st.product_details_id = '.$data['idProduct'].'
            UNION 
            SELECT pd.id AS product_details_id,p.name AS name_product,m.name AS mark,pd.lot,u.name AS units,pr.name AS providers,i.code AS invima_codes,td.quant_output, su.name AS storage_name,su.id AS storage_id,  st.id AS storage_inputs_id , td.id AS transfer_id FROM transfer_details  AS td
            INNER JOIN storage_inputs AS st ON td.storage_inputs_id = st.id
            INNER JOIN product_details AS pd ON td.product_details_id = pd.id
            INNER JOIN products AS p ON pd.products_id = p.id
            INNER JOIN marks AS m ON pd.marks_id = m.id
            INNER JOIN providers AS pr ON pd.providers_id = pr.id
            INNER JOIN units AS u ON pd.units_id = u.id
            INNER JOIN invima_codes AS i ON pd.invima_codes_id = i.id
            INNER JOIN storage_ubications AS su ON td.storage_ubications_id = su.id
            WHERE   st.remaining > 0
                AND st.storage_ubications_id ='.$data['idStorage'].' 
                AND st.product_details_id = '.$data['idProduct'].'')->fetchAll('assoc'); 

        // pr($query);

        if($query){

             $success = true;

             $this->set(compact('success','query'));

        }else{

            $success = false;

            $this->set(compact('success'));
        }
        
        
    }


    public function productReasume( $page ){

        //  $this->autoRender = false;    

        $conn = ConnectionManager::get('default');

        if( !empty( $page ) || $page == 0 ){
            $page = ( $page*15==0? 1 : $page*15 );
            $limit = " LIMIT " . $page . ",10 ";
        }else{
            $limit = '';
        }

        $query = $conn->execute('
          SELECT 
            stUb.name as bodega,
            prd.name as producto,
            sum(stInp.quant_input) as entradas,  
            sum(stInp.remaining) as salidas
                
          FROM storage_inputs  as stInp
          left join storage_ubications as stUb  on stInp.storage_ubications_id =  stUb.id
            left join product_details as pdDet on pdDet.id = stInp.product_details_id
            left join products as prd on prd.id = pdDet.products_id
            group by stUb.name,  prd.name
            order by 1,2'. $limit .';')->fetchAll('assoc'); 
         //   pr($query);
         
      $List= [];
      foreach ($query as $row) {

                array_push($List, $row);
        }
         
           if($List)
        {
            $success = true;

            $this->set(compact('success', 'List'));
        }else{

            $success = false;

            $this->set(compact('success'));
        }
    }

}
