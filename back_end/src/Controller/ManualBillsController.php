<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Bills\getBillNumer;

/**
 * ManualBills Controller
 *
 * @property \App\Model\Table\ManualBillsTable $ManualBills
 */
class ManualBillsController extends AppController
{


   public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['saveBill']);

    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['BillResolutions', 'People', 'Users']
        ];
        $manualBills = $this->paginate($this->ManualBills);

        $this->set(compact('manualBills'));
        $this->set('_serialize', ['manualBills']);
    }

    /**
     * View method
     *
     * @param string|null $id Manual Bill id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $manualBill = $this->ManualBills->get($id, [
            'contain' => ['BillResolutions', 'People', 'Users', 'Products']
        ]);

        $this->set('manualBill', $manualBill);
        $this->set('_serialize', ['manualBill']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $manualBill = $this->ManualBills->newEntity();
        if ($this->request->is('post')) {
            $manualBill = $this->ManualBills->patchEntity($manualBill, $this->request->data);
            if ($this->ManualBills->save($manualBill)) {
                $this->Flash->success(__('The manual bill has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The manual bill could not be saved. Please, try again.'));
            }
        }
        $billResolutions = $this->ManualBills->BillResolutions->find('list', ['limit' => 200]);
        $people = $this->ManualBills->People->find('list', ['limit' => 200]);
        $users = $this->ManualBills->Users->find('list', ['limit' => 200]);
        $products = $this->ManualBills->Products->find('list', ['limit' => 200]);
        $this->set(compact('manualBill', 'billResolutions', 'people', 'users', 'products'));
        $this->set('_serialize', ['manualBill']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Manual Bill id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $manualBill = $this->ManualBills->get($id, [
            'contain' => ['Products']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $manualBill = $this->ManualBills->patchEntity($manualBill, $this->request->data);
            if ($this->ManualBills->save($manualBill)) {
                $this->Flash->success(__('The manual bill has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The manual bill could not be saved. Please, try again.'));
            }
        }
        $billResolutions = $this->ManualBills->BillResolutions->find('list', ['limit' => 200]);
        $people = $this->ManualBills->People->find('list', ['limit' => 200]);
        $users = $this->ManualBills->Users->find('list', ['limit' => 200]);
        $products = $this->ManualBills->Products->find('list', ['limit' => 200]);
        $this->set(compact('manualBill', 'billResolutions', 'people', 'users', 'products'));
        $this->set('_serialize', ['manualBill']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Manual Bill id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $manualBill = $this->ManualBills->get($id);
        if ($this->ManualBills->delete($manualBill)) {
            $this->Flash->success(__('The manual bill has been deleted.'));
        } else {
            $this->Flash->error(__('The manual bill could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


 public function getBillNumer($billTypeId,$center){

        $this->loadModel('BillResolutions');


        $resolution = $this->BillResolutions->find('all', ['order'=>['BillResolutions.id DESC'], 'conditions'=>['BillResolutions.bill_types_id' => $billTypeId,
                         'BillResolutions.center_id'=>$center]])->first();


        $newNumber = $this->updateCurrentNumerResolution($resolution['id'], $resolution['current_number']);

        if($newNumber !== false){

            return Array('newNumber'=>$resolution['prefix'].$newNumber, 'id'=> $resolution['id']);

        }else{

            return false;    
        }

        

    }

    /**
     * actualiza el numero de resolucion en bill resolution
     * @param  [type] $id              Bill resolution
     * @param  [type] $current_number  ultimo numero en facturacion
     * @return [type]                 [description]
     */
    public function updateCurrentNumerResolution($id, $current_number){

        $this->loadModel('BillResolutions');

        $BillResolutions = $this->BillResolutions->get($id, [
            'contain' => []
        ]);

        $BillResolutions = $this->BillResolutions->patchEntity($BillResolutions, ['current_number' => ($current_number + 1)]);
    
        if ($this->BillResolutions->save($BillResolutions)) {

            return  ($current_number + 1);
    
        } else {

            return false;
        }
    }


    public function saveBill(){

        //$this->autoRender = false;

        $data = $this->request->data;

        //unset($data['center']);

       // $data['users_id'] = $this->Auth->user('id'); // obtiene el usuario
        
        $resolution = $this->getBillNumer($data['bill_types_id'], $data['center']); // obtiene el consecutivo de facturacion.


        $data['bill_resolutions_id'] = $resolution['id'];

        $data['bill_number'] = $resolution['newNumber'];

        // pr($resolution);

        

        // Guardar el registro en la tabla de bills
        
        $this->loadModel('Bills');
        
        $newBill = $this->Bills->newEntity();

        $bill = [
            "bill_number"         => $resolution['newNumber'],
            "bill_resolutions_id" => $resolution['id'],
            "users_id"            => $data['users_id'],
            "canceled"            => '0',
            "create"              => date('Y-m-d'),
            "modified"            => date('Y-m-d')

        ];

        $newBill = $this->Bills->patchEntity($newBill, $bill);

        $this->Bills->save($newBill);

        if(!$this->Bills->save($newBill)){
            
            $success = false;
            $errors  = $newBill->errors();
            $this->set( compact( 'success', 'errors' ) );





        
        }else{

            $data['bills_id'] = $newBill['id'];


            /* 
            * Guardado de los valores de la factura factura
            */


            $this->loadModel('Payments');

            $payment = $data;

            $newPayment = $this->Payments->newEntity();

            $payment['payment_type_id'] = 1;

            $newPayment = $this->Payments->patchEntity($newPayment, $payment);
            
            if ($this->Payments->save($newPayment)) {
            
                $success = true;
            
            } else {
                pr($payment);
                $success = false;
                var_dump($newPayment->errors());
                exit();
            }


        
        }



        








        
        // Para la tabla manual bills
        $data['entity_id'] = $data['people_id'];
        $data['entity_type'] = ( ( $data['bill_types_id'] == 2 )? 0 : 1 );


        $newManualBill = $this->ManualBills->newEntity();
    
        $newManualBill = $this->ManualBills->patchEntity($newManualBill, $data);
        
        if ($this->ManualBills->save($newManualBill)) {

            $success = true;

            $this->set(compact('success','newManualBill'));

        } else {
           
            $errors = $newManualBill->errors();

            $success = false;

            $this->set(compact('success','errors'));        

        }
        
    }

}
