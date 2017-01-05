<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Datasource\ConnectionManager;

/**
 * BillDetails Controller
 *
 * @property \App\Model\Table\BillDetailsTable $BillDetails
 */
class BillDetailsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Bills']
        ];
        $billDetails = $this->paginate($this->BillDetails);

        $this->set(compact('billDetails'));
        $this->set('_serialize', ['billDetails']);
    }

    /**
     * View method
     *
     * @param string|null $id Bill Detail id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $billDetail = $this->BillDetails->get($id, [
            'contain' => ['Bills']
        ]);

        $this->set('billDetail', $billDetail);
        $this->set('_serialize', ['billDetail']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add( $data ){


        if( empty( $data ) ){

            $data = $this->request->data;

        }

         $data[ 'type' ] =  ( $this->isManual( $data['bills_id'] )? '1' : '0' );


        $billDetail = $this->BillDetails->newEntity();
        
        $billDetail = $this->BillDetails->patchEntity($billDetail, $data);
        if ($this->BillDetails->save($billDetail)) {
            

            // Guarda los items que se cobraron en la factura
            $this->saveItemBillDetails( $data['items'], $billDetail->id );
            
            
        } else {

            $success = false;
            $resultado = $billDetail->errors();

            $this->set( compact( 'success', 'resultado' ) );
        
        }
        
    }


    /*
      Carlos Felipe Aguirre Taborda GL STUDIOS S.A.S
      Fecha: 2016-12-19 16:10:06
      Tipo de dato de retorno:  void
      Descripción: guarda los items de la factura en la tabla BillDetailsItems
    */
    private function saveItemBillDetails( $items, $id ){
    


        $this->loadModel( 'BillDetailsItems' );

        foreach( $items as $valor){
            

            $valor['bill_details_a_id'] = $id;
           

            $resultado = $this->BillDetailsItems->query()
                                   ->insert( array_keys( $valor ) )
                                   ->values( $valor )
                                   ->execute();
        
        }


    }



    /*
      Carlos Felipe Aguirre Taborda GL STUDIOS S.A.S
      Fecha: 2016-12-19 15:26:58
      Tipo de dato de retorno:  void
      Descripción: Checa si una factura es manual o no  en caso de que lo sea retorna true de lo contrario false
    */
    private function isManual( $id ){

        $conection = ConnectionManager::get('default');
        $resultado = $conection->execute(
            'SELECT bills_id FROM orders_bills WHERE bills_id = ' . $id

        )->fetchAll('assoc');


        if( empty( $resultado ) ){

            return true; 

        }else{

            return false;

        }

    }


    /**
     * Edit method
     *
     * @param string|null $id Bill Detail id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $billDetail = $this->BillDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $billDetail = $this->BillDetails->patchEntity($billDetail, $this->request->data);
            if ($this->BillDetails->save($billDetail)) {
                $this->Flash->success(__('The bill detail has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bill detail could not be saved. Please, try again.'));
            }
        }
        $bills = $this->BillDetails->Bills->find('list', ['limit' => 200]);
        $this->set(compact('billDetail', 'bills'));
        $this->set('_serialize', ['billDetail']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Bill Detail id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $billDetail = $this->BillDetails->get($id);
        if ($this->BillDetails->delete($billDetail)) {
            $this->Flash->success(__('The bill detail has been deleted.'));
        } else {
            $this->Flash->error(__('The bill detail could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }



    // Obtiene los items de una orden cuando esta ya se factó
    // Carlos Felipe Aguirre Taborda
    // 2016-11-05 11:
    // 
    public function getBillDetails(){

        $orderConsec = $this->request->data[ 'orderConsec' ];

        $connection = ConnectionManager::get('default');
        $respuesta = $connection->execute(
            "SELECT 
                    bill_details_items.id,
                    bill_details_items.item_id AS item_id, 
                    bill_details_items.value AS valor, 
                    bill_details_items.quantity AS cant, 
                    ( bill_details_items.quantity*bill_details_items.value ) as cost,
                    IF( bill_details_items.item_types_id='2', 
                        (SELECT cup FROM studies WHERE id = item_id LIMIT 1 ), 
                        (SELECT cup FROM services WHERE id = item_id LIMIT 1)  
                    ) 
                    as ref,
                    IF( bill_details_items.item_types_id='2', 
                        (SELECT name FROM studies WHERE id = item_id LIMIT 1 ), 
                        (SELECT name FROM services WHERE id = item_id LIMIT 1)  
                    ) as 'desc',
                    NULL as type,
                    NULL as services,
                    NULL as supplies
                    
                FROM 
                    bill_details_items
                    INNER JOIN bill_details
                    ON
                        bill_details_items.bill_details_a_id = bill_details.id
                    INNER JOIN bills
                    ON
                        bill_details.bills_id = bills.id
                    INNER JOIN orders_bills
                    ON
                        bills.id = orders_bills.bills_id
                    INNER JOIN orders
                    ON 
                        orders_bills.orders_id = orders.id
                WHERE 
                    orders.order_consec = '" . $orderConsec . "'

                GROUP BY item_id"

        )->fetchAll('assoc');

        if( !empty( $respuesta ) ){
        
            $success = true;
            $this->set( compact( 'success', 'respuesta' ) );
        
        }
        else{

            $success = false;
            $this->set( compact( 'success', 'respuesta' ) );

        }


    }

    /**
     * Obtiene todos los detalles de una factura.
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-07
     * @datetime 2016-12-07T14:13:38-0500
     * @return   [type]                   [description]
     */
    public function getBillDetailsByBillId(){
        // $this->loadModel();
        $billId =$this->request->data['id'];
        // var_dump($billId);
        $connection = ConnectionManager::get('default');
        $resultado = $connection->execute(
            "SELECT 
                    bill_details_items.id,
                    bill_details_items.item_id AS item_id, 
                    bill_details_items.value AS valor, 
                    bill_details_items.quantity AS cant, 
                    ( bill_details_items.quantity*bill_details_items.value ) as cost,
                    IF( bill_details_items.item_types_id='2', 
                        (SELECT cup FROM studies WHERE id = item_id LIMIT 1 ), 
                        (SELECT cup FROM services WHERE id = item_id LIMIT 1)  
                    ) 
                    as ref,
                    IF( bill_details_items.item_types_id='2', 
                        (SELECT name FROM studies WHERE id = item_id LIMIT 1 ), 
                        (SELECT name FROM services WHERE id = item_id LIMIT 1)  
                    ) as 'desc',
                    NULL as type,
                    NULL as services,
                    NULL as supplies
                    
                FROM 
                    bill_details_items
                    INNER JOIN bill_details
                    ON
                        bill_details_items.bill_details_a_id = bill_details.id
                    INNER JOIN bills
                    ON
                        bill_details.bills_id = bills.id
                    INNER JOIN orders_bills
                    ON
                        bills.id = orders_bills.bills_id
                    INNER JOIN orders
                    ON 
                        orders_bills.orders_id = orders.id
                WHERE 
                     bills.id = ".$billId."")->fetchAll('assoc');
       
        // $bill = $this->BillDetails->find('all', 
        //         ['conditions'=>['BillDetails.bills_id'=> $billId]]
        //         )->first();

       // var_dump($resultado);
            if($resultado){
                $success = true;
                $this->set(compact('success','resultado'));
            }else{
                $success = false;
              //  $error = $bill->errors();
                $this->set(compact('success'));

            }

        }
    
}
