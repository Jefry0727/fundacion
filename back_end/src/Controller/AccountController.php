<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Account Controller
 *
 * @property \App\Model\Table\AccountTable $Account
 */
class AccountController extends AppController
{



    public function initialize(){

        parent::initialize();

        $this->Auth->allow([]);


        $this->loadComponent('ResourceManager');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
        'contain' => ['AccountDocuments', 'CostCenters', 'Users']
        ];
        $account = $this->paginate($this->Account);

        $this->set(compact('account'));
        $this->set('_serialize', ['account']);
    }

    /**ESTRUCTURA DE TABLA EN BD
     * 
     * id, account_documents_id, cost_centers_id, auxiliar, description, debit_pcga, credit_pcga, accountcol, nit, social_reazon, debit_altern_pcga, credit_altern_pcga, cpto_cash_flow, desc_cpto_cash_flow, notes, base_gravable_pcga, docto_banc, debit_niif, credit_niif, debit_altern_niif, credit_altern_niif, base_gravable_niif, debit_ajust, credit_ajust, debit_altern_ajust, credit_altern_ajust, base_gravable_ajust, state, send_interfaz, created, modified, date_send, users_id
     */

    public function saveNewAccount($account){

        $newAccount  = $this->Account->newEntity();
        $newAccount = $this->Account->patchEntity($newAccount, $account->toArray());

        if ($this->Account->save($newAccount)) {
            $success = true;
               //$this->set(compact('success'));
                // debug($newAccount);
        }else
        {

            $success = false;
            $error = $newAccount->errors();

            if( $error ){

                pr( $error);

            }
            //     var_dump($error);
              // $this->set(compact('success','error'));
        }


    }


    /**
     * Obtenr Facturacion Manual
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-11-17
     * @datetime 2016-11-17T15:22:08-0500
     */
    public function addAccountManual(){



    }


    /**
     * Adicionar Un FE o Facturacion a Credito para Interfaz
     * '1', 'FACTURACION CREDITO', 'FE' 
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-11-16
     * @datetime 2016-11-16T10:59:07-0500
     */
    public function addFE($order_bills){


        if($order_bills){
            // $this->autoRender = false;


        $account_documents_id = 1; //FE

         //$user =  $this->Auth->user('id');
        $user = 1;
        //  var_dump($user);


        $this->loadModel('OrdersBills');
        //Obtiene la Orden y la facturacion. 
        $_bill = $this->OrdersBills->get($order_bills, [
            'contain' => ['Orders.Clients','Bills.Payments']
            ])->toArray();


        // debug($_bill);

        //Obtiene Info Orden
        $Orden = $_bill['order'];
        
        //Carga toda la Info del centro de costos y la unidad de negocio. 
        //$this->loadModel('CostCenters');

        // $costCenter = $this->CostCenters->get($Orden['cost_centers_id'],[
        //     'contain'=>['BusinessUnits']])->toArray();

        // var_dump('cost center');
        // debug($costCenter);

        //Obtiene el Pago -> saldo en debito o en credito. 
        $bill = $_bill['bill'];
        $payment = $bill['payments']['0'];

        $state = 1;
        $send_interfaz  = 0;



         /**
          * Crear Regristro Credit
          */
         

         $creditAccount = $this->Account->newEntity();
         $creditAccount['entitys_id'] = $bill['id'];
         $creditAccount['account_documents_id'] = $account_documents_id;
         $creditAccount['cost_centers_id'] = $Orden['cost_centers_id'];
         $creditAccount['users_id'] = $user;
         $creditAccount['auxiliar'] = 41250501;
         $creditAccount['description'] = 'Unidad Funcional de Apoyo Diagnostico';
         $creditAccount['debit_pcga'] = $payment['debit'];
         $creditAccount['credit_pcga'] = $payment['credit'];
         $creditAccount['nit'] = $Orden['client']['nit'];
         $creditAccount['social_reazon'] =  $Orden['client']['social_reazon'];
         $creditAccount['debit_altern_pcga'] = 0;
         $creditAccount['credit_altern_pcga'] = 0;
         $creditAccount['cpto_cash_flow'] = '';
         $creditAccount['desc_cpto_cash_flow'] = '';
         $creditAccount['notes'] = 'DOCUMETNO GENERADO INTERFASE CONTABILIZAMOS DOCUMENTO '.$bill['bill_number'];
         $creditAccount['base_gravable_pcga'] = 0;
         $creditAccount['docto_banc'] = '';
         $creditAccount['debit_niif'] = $payment['debit'];
         $creditAccount['credit_niif'] = $payment['credit'];
         $creditAccount['debit_altern_niif'] = 0;
         $creditAccount['credit_altern_niif'] = 0;
         $creditAccount['base_gravable_niif'] = 0;
         $creditAccount['debit_ajust'] = $payment['debit'];
         $creditAccount['credit_ajust'] = $payment['credit'];
         $creditAccount['debit_altern_ajust'] = 0;
         $creditAccount['credit_altern_ajust']= 0;
         $creditAccount['base_gravable_ajust'] = 0;
         $creditAccount['state'] = 1;
         $creditAccount['send_interfaz'] = 0; 

         
         $this->saveNewAccount($creditAccount);

       //   var_dump('Credito');
        //  debug($creditAccount);


         /**
          * Crear Registro Debit
          */
         
         $debitAccount = $this->Account->newEntity();
         $debitAccount['entitys_id'] = $bill['id'];
         $debitAccount['account_documents_id'] = $account_documents_id;
         $debitAccount['cost_centers_id'] = $Orden['cost_centers_id'];
         $debitAccount['users_id'] = $user;
         $debitAccount['auxiliar'] = 13050501;
         $debitAccount['description'] = $Orden['client']['social_reazon'];
         $debitAccount['debit_pcga'] = $payment['credit']; // intercambia valore .
         $debitAccount['credit_pcga'] = $payment['debit'];
         $debitAccount['nit'] = $Orden['client']['nit'];
         $debitAccount['social_reazon'] =  $Orden['client']['social_reazon'];
         $debitAccount['debit_altern_pcga'] = 0;
         $debitAccount['credit_altern_pcga'] = 0;
         $debitAccount['cpto_cash_flow'] = '';
         $debitAccount['desc_cpto_cash_flow'] = '';
         $debitAccount['notes']= 'DOCUMETNO GENERADO INTERFASE CONTABILIZAMOS DOCUMENTO '.$bill['bill_number'];
         $debitAccount['base_gravable_pcga'] = 0;
         $debitAccount['docto_banc'] = '';
         $debitAccount['debit_niif'] = $payment['credit'];
         $debitAccount['credit_niif'] = $payment['debit'];
         $debitAccount['debit_altern_niif'] = 0;
         $debitAccount['credit_altern_niif'] = 0;
         $debitAccount['base_gravable_niif'] = 0;
         $debitAccount['debit_ajust'] = $payment['credit'];
         $debitAccount['credit_ajust'] = $payment['debit'];
         $debitAccount['debit_altern_ajust'] = 0;
         $debitAccount['credit_altern_ajust']= 0;
         $debitAccount['base_gravable_ajust'] = 0;
         $debitAccount['state'] = 1;
         $debitAccount['send_interfaz'] = 0; 

         $this->saveNewAccount($debitAccount);

//          var_dump('Debito');
         // debug($debitAccount);

     }

 }

    /**
     * Adicionar un FV o Facturacion de Contado par Interfaz
     *'2', 'FACTURACION CONTADO', 'FV'
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-11-16
     * @datetime 2016-11-16T11:00:20-0500
     */
    public function addFV($order_bills){

        //$this->autoRender = false;
        if($order_bills){

        $account_documents_id = 2; //FV

       // $user = $this->Auth->user('id');

        $user = 1 ;
        $this->loadModel('OrdersBills');
        //Obtiene la Orden y la facturacion. 
        $_bill = $this->OrdersBills->get($order_bills, [
            'contain' => ['Orders.Patients.People','Bills.Payments']
            ])->toArray();



        //Obtiene Info Orden
        $Orden = $_bill['order'];
        

        //Carga toda la Info del centro de costos y la unidad de negocio. 
        //$this->loadModel('CostCenters');

        // $costCenter = $this->CostCenters->get($Orden['cost_centers_id'],[
        //     'contain'=>['BusinessUnits']])->toArray();

        // var_dump('cost center');
        // debug($costCenter);

        //Obtiene el Pago -> saldo en debito o en credito. 
        $bill = $_bill['bill'];
        $payment = $bill['payments']['0'];


        $state = 1;
        $send_interfaz  = 0;


        /**
          * Crear Regristro Credit
        */

        /**
         *  DEBITO
         * Esta contabilizacion cuando es un paciente
         */
        $paciente = $Orden['patient']['person'];

        $debitAccount = $this->Account->newEntity();
        $debitAccount['entitys_id'] = $bill['id'];
        $debitAccount['account_documents_id'] = $account_documents_id;
        $debitAccount['cost_centers_id'] = $Orden['cost_centers_id'];
        $debitAccount['users_id'] = $user;
        $debitAccount['auxiliar'] = 11050501;
        $debitAccount['description'] = 'Unidad Funcional de Apoyo Diagnostico';
        $debitAccount['debit_pcga'] = $payment['debit'];
        $debitAccount['credit_pcga'] = $payment['credit'];
        $debitAccount['nit'] = $paciente['identification'];
        $debitAccount['social_reazon'] =  $paciente['last_name'].' '.
                    $paciente['last_name_two'].' '.
                    $paciente['first_name'].' '.
                    $paciente['middle_name'];
        $debitAccount['debit_altern_pcga'] = 0;
        $debitAccount['credit_altern_pcga'] = 0;
        $debitAccount['cpto_cash_flow'] = '';
        $debitAccount['desc_cpto_cash_flow'] = '';
        $debitAccount['notes'] = 'DOCUMETNO GENERADO INTERFASE CONTABILIZAMOS DOCUMENTO'.$bill['bill_number'];
        $debitAccount['base_gravable_pcga'] = 0;
        $debitAccount['docto_banc'] = '';
        $debitAccount['debit_niif'] = $payment['debit'];
        $debitAccount['credit_niif'] = $payment['credit'];
        $debitAccount['debit_altern_niif'] = 0;
        $debitAccount['credit_altern_niif'] = 0;
        $debitAccount['base_gravable_niif'] = 0;
        $debitAccount['debit_ajust'] = $payment['debit'];
        $debitAccount['credit_ajust'] = $payment['credit'];
        $debitAccount['debit_altern_ajust'] = 0;
        $debitAccount['credit_altern_ajust']= 0;
        $debitAccount['base_gravable_ajust'] = 0;     
        $debitAccount['state'] = 1;
        $debitAccount['send_interfaz'] = 0; 




        $this->saveNewAccount($debitAccount);


         /**
          * CREDITO
          * Crear Registro Debit
          */
         
         $creditAccount = $this->Account->newEntity();
         $creditAccount['entitys_id'] = $bill['id'];
         $creditAccount['account_documents_id'] = $account_documents_id;
         $creditAccount['cost_centers_id'] = $Orden['cost_centers_id'];
         $creditAccount['users_id'] = $user;
         $creditAccount['auxiliar'] = 41250501;
         $creditAccount['description'] = $paciente['last_name'].' '.
                                          $paciente['last_name_two'].' '.
                                          $paciente['first_name'].' '.
                                          $paciente['middle_name'];
         $creditAccount['debit_pcga'] = $payment['credit'];
         $creditAccount['credit_pcga'] = $payment['debit']+ $payment['discount']+ $payment['donation'];
         $creditAccount['nit'] = $paciente['identification'];
         $creditAccount['social_reazon'] =  $paciente['last_name'].' '.
                                          $paciente['last_name_two'].' '.
                                          $paciente['first_name'].' '.
                                          $paciente['middle_name'];
         $creditAccount['debit_altern_pcga'] = 0;
         $creditAccount['credit_altern_pcga'] = 0;
         $creditAccount['cpto_cash_flow'] = '';
         $creditAccount['desc_cpto_cash_flow'] = '';
         $creditAccount['notes']= 'DOCUMETNO GENERADO INTERFASE CONTABILIZAMOS DOCUMENTO '.$bill['bill_number'];
         $creditAccount['base_gravable_pcga'] = 0;
         $creditAccount['docto_banc'] = '';
         $creditAccount['debit_niif'] = $payment['credit'];
         $creditAccount['credit_niif'] = $payment['debit']+ $payment['discount']+ $payment['donation'];
         $creditAccount['debit_altern_niif'] = 0;
         $creditAccount['credit_altern_niif'] = 0;
         $creditAccount['base_gravable_niif'] = 0;
         $creditAccount['debit_ajust'] = $payment['credit'];
         $creditAccount['credit_ajust'] = $payment['debit']+ $payment['discount']+ $payment['donation'];
         $creditAccount['debit_altern_ajust'] = 0;
         $creditAccount['credit_altern_ajust']= 0;
         $creditAccount['base_gravable_ajust'] = 0;
         $creditAccount['state'] = 1;
         $creditAccount['send_interfaz'] = 0; 

         $this->saveNewAccount($creditAccount);

         /**
          * CONTABILIZACION DE UN DESCUENTO
          */
         if($payment['discount']> 0){

            $discountAccount = $this->Account->newEntity();
            $discountAccount['entitys_id'] = $bill['id'];
            $discountAccount['account_documents_id'] = $account_documents_id;
            $discountAccount['cost_centers_id'] = $Orden['cost_centers_id'];
            $discountAccount['users_id'] = $user;
            $discountAccount['auxiliar'] = 41250501;
            $discountAccount['description'] = $paciente['last_name'].' '.
                                              $paciente['last_name_two'].' '.
                                              $paciente['first_name'].' '.
                                              $paciente['middle_name'];
            $discountAccount['debit_pcga'] = $payment['discount'];
            $discountAccount['credit_pcga'] = $payment['credit'];
            $discountAccount['nit'] = $paciente['identification'];
            $discountAccount['social_reazon'] =  $paciente['last_name'].' '.
                                              $paciente['last_name_two'].' '.
                                              $paciente['first_name'].' '.
                                              $paciente['middle_name'];
            $discountAccount['debit_altern_pcga'] = 0;
            $discountAccount['credit_altern_pcga'] = 0;
            $discountAccount['cpto_cash_flow'] = '';
            $discountAccount['desc_cpto_cash_flow'] = '';
            $discountAccount['notes']= 'DOCUMETNO GENERADO INTERFASE CONTABILIZAMOS DESCUENTO EN '.$bill['bill_number'];
            $discountAccount['base_gravable_pcga'] = 0;
            $discountAccount['docto_banc'] = '';
            $discountAccount['debit_niif'] = $payment['discount'];
            $discountAccount['credit_niif'] = $payment['credit'];
            $discountAccount['debit_altern_niif'] = 0;
            $discountAccount['credit_altern_niif'] = 0;
            $discountAccount['base_gravable_niif'] = 0;
            $discountAccount['debit_ajust'] = $payment['discount'];
            $discountAccount['credit_ajust'] = $payment['credit'];
            $discountAccount['debit_altern_ajust'] = 0;
            $discountAccount['credit_altern_ajust']= 0;
            $discountAccount['base_gravable_ajust'] = 0;
            $discountAccount['state'] = 1;
            $discountAccount['send_interfaz'] = 0; 

            $this->saveNewAccount($discountAccount);


        }

        /**
         * CONTABILIZACION DE UNA DONACION.
         */
         if($payment['donation']> 0){

            $donationAccount = $this->Account->newEntity();
            $donationAccount['entitys_id'] = $bill['id'];
            $donationAccount['account_documents_id'] = $account_documents_id;
            $donationAccount['cost_centers_id'] = $Orden['cost_centers_id'];
            $donationAccount['users_id'] = $user;
            $donationAccount['auxiliar'] = 41250501;
            $donationAccount['description'] = $paciente['last_name'].' '.
                                              $paciente['last_name_two'].' '.
                                              $paciente['first_name'].' '.
                                              $paciente['middle_name'];
            $donationAccount['debit_pcga'] = $payment['donation'];
            $donationAccount['credit_pcga'] = $payment['credit'];
            $donationAccount['nit'] = $paciente['identification'];
            $donationAccount['social_reazon'] =  $paciente['last_name'].' '.
                                              $paciente['last_name_two'].' '.
                                              $paciente['first_name'].' '.
                                              $paciente['middle_name'];
            $donationAccount['debit_altern_pcga'] = 0;
            $donationAccount['credit_altern_pcga'] = 0;
            $donationAccount['cpto_cash_flow'] = '';
            $donationAccount['desc_cpto_cash_flow'] = '';
            $donationAccount['notes']= 'DOCUMETNO GENERADO INTERFASE CONTABILIZAMOS DONACION EN '.$bill['bill_number'];
            $donationAccount['base_gravable_pcga'] = 0;
            $donationAccount['docto_banc'] = '';
            $donationAccount['debit_niif'] = $payment['donation'];
            $donationAccount['credit_niif'] = $payment['credit'];
            $donationAccount['debit_altern_niif'] = 0;
            $donationAccount['credit_altern_niif'] = 0;
            $donationAccount['base_gravable_niif'] = 0;
            $donationAccount['debit_ajust'] = $payment['donation'];
            $donationAccount['credit_ajust'] = $payment['credit'];
            $donationAccount['debit_altern_ajust'] = 0;
            $donationAccount['credit_altern_ajust']= 0;
            $donationAccount['base_gravable_ajust'] = 0;
            $donationAccount['state'] = 1;
            $donationAccount['send_interfaz'] = 0; 

            $this->saveNewAccount($donationAccount);


        }


    }



}
    /**
     * Adicionar un SA o Salida de Almacen para interfaz 
     * '3', 'SALIDA ALMACEN', 'SA'
     * [addSA description]
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-11-16
     * @datetime 2016-11-16T11:01:28-0500
     */
    public function addSA(){


    }
    /**
     * Adicionar un DV o Devoluciones
     * '4', 'DEVOLUCIONES ', 'DV'
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-11-16
     * @datetime 2016-11-16T11:02:14-0500
     */
    public function addDV(){


    }

    /**
     * Adicionar un SB o  Salida de Bodega 
     * '5', 'SALIDA DE BODEGA', 'SB'
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-11-16
     * @datetime 2016-11-16T11:02:39-0500
     */
    public function addSB(){

    }

    /**
     * Adicionar una NV o Nota de Venta
     * '6', 'NOTA DE VENTA', 'NV'
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-11-16
     * @datetime 2016-11-16T11:03:22-0500
     */
    public function addNV(){

    }  

    /**
     * Adicionar una CP o cuanta por pagar
     * '7', 'CUENTAS POR PAGAR', 'CP'
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-11-16
     * @datetime 2016-11-16T11:03:55-0500
     */
    public function addCP(){

    }
    /**
     * Adicionar una EA o entrada de Almacen
     * '8', 'ENTRADA ALMACEN', 'EA'
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-11-16
     * @datetime 2016-11-16T11:04:34-0500
     */
    public function addEA(){

    }






    //_--------------------------------------------------------------
    
    
     /**
     * View method
     *
     * @param string|null $id Account id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
     public function view($id = null)
     {
        $account = $this->Account->get($id, [
            'contain' => ['AccountDocuments', 'CostCenters', 'Users']
            ]);

        $this->set('account', $account);
        $this->set('_serialize', ['account']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $account = $this->Account->newEntity();
        if ($this->request->is('post')) {
            $account = $this->Account->patchEntity($account, $this->request->data);
            if ($this->Account->save($account)) {
                $this->Flash->success(__('The account has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account could not be saved. Please, try again.'));
            }
        }
        $accountDocuments = $this->Account->AccountDocuments->find('list', ['limit' => 200]);
        $costCenters = $this->Account->CostCenters->find('list', ['limit' => 200]);
        $users = $this->Account->Users->find('list', ['limit' => 200]);
        $this->set(compact('account', 'accountDocuments', 'costCenters', 'users'));
        $this->set('_serialize', ['account']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Account id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $account = $this->Account->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $account = $this->Account->patchEntity($account, $this->request->data);
            if ($this->Account->save($account)) {
                $this->Flash->success(__('The account has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account could not be saved. Please, try again.'));
            }
        }
        $accountDocuments = $this->Account->AccountDocuments->find('list', ['limit' => 200]);
        $costCenters = $this->Account->CostCenters->find('list', ['limit' => 200]);
        $users = $this->Account->Users->find('list', ['limit' => 200]);
        $this->set(compact('account', 'accountDocuments', 'costCenters', 'users'));
        $this->set('_serialize', ['account']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Account id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $account = $this->Account->get($id);
        if ($this->Account->delete($account)) {
            $this->Flash->success(__('The account has been deleted.'));
        } else {
            $this->Flash->error(__('The account could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


}
