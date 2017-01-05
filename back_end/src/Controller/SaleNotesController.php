<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SaleNotes Controller
 *
 * @property \App\Model\Table\SaleNotesTable $SaleNotes
 */
class SaleNotesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
        'contain' => ['Bills', 'Users']
        ];
        $saleNotes = $this->paginate($this->SaleNotes);

        $this->set(compact('saleNotes'));
        $this->set('_serialize', ['saleNotes']);
    }


  public function initialize() 
   {
    parent::initialize();

    $this->Auth->allow(['saleNoteBills']);


    $this->loadComponent('StringUtils');
}
    /**
     * View method
     *
     * @param string|null $id Sale Note id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $saleNote = $this->SaleNotes->get($id, [
            'contain' => ['Bills', 'Users']
            ]);

        $this->set('saleNote', $saleNote);
        $this->set('_serialize', ['saleNote']);
    }

    /**
     * [cancelUpdateBill description]
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-07
     * @datetime 2016-12-07T16:33:05-0500
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function saleNoteUpdateBill($id){

        $this->loadModel('Bills');

        $editBill = $this->Bills->get($id);

        $editBill = $this->Bills->patchEntity($editBill, $editBill->toArray());

        if ($this->Bills->save($editBill)) {

            $success = true;

            return $success;

         //  $this->set(compact('success','editBill'));
        } else {

            $errors = $editBill->errors();

            return $errors;

       //     $this->set(compact('success','errors'));

        }
    }


    /**
     * Registra en el sistema una nota de venta.
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-07
     * @datetime 2016-12-07T16:41:38-0500
     * @return   [type]                   [description]
     */
    public function saleNoteBills(){


        $data = $this->request->data;
        $result = null;

        foreach ($data as $key => $value) {


            $this->addSaleNotePayments($value['bills_id']);

            $id = $value['bills_id'];

        // pr( $this->requestAction(
        //             array('controller' => 'Bills', 'action' => 'saleNote'),
        //             array('pass' => array($id))
        //         ));

            $cancel = $this->saleNoteUpdateBill($id);

            $saleNote = $this->SaleNotes->newEntity();

            $cancellBill['user_id']  = $this->Auth->user('id');

           // var_dump( $value );


            $saleNote = $this->SaleNotes->patchEntity($saleNote, $value);


            if ($this->SaleNotes->save($saleNote)) {

                $success = true;
                $result .= $saleNote;

           // $this->set(compact('success','saleNote'));

            } else {

                $success = false;

                $errors = $saleNote->errors();

           // $this->set(compact('success','errors'));

            }
        }

        //debug($saleNote);
        if($success){
           $this->set(compact('success','saleNote'));
       }
   }

    /**
     * Registra el pago de la devolucion. 
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-19
     * @datetime 2016-12-19T11:40:00-0500
     * @param    [type]                   $data [description]
     */
    private function addSaleNotePayments($data) {

        $this->loadModel('Payments');

        $payment = $this->Payments->find('all', ['conditions'=>['Payments.bills_id'=>$data, 
            'Payments.payment_type_id'=> 1]])->first();

        $payment['payment_type_id'] = 2;
        unset ($payment['id'] );  

        $newPayment = $this->Payments->newEntity();
        $newPayment  = $this->Payments->patchEntity($newPayment, $payment->toArray());

        if($this->Payments->save($newPayment)){
            $success = true;
       //         var_dump($newPayment);
                // exit();
            return $success;

            # code...
        }else {

            $error = $newPayment->errors();
         //       var_dump($error);
            //  exit();
                # code...
            return $error;
        }
        


    }


    /**
     * Obtiene razonde Nota de venta
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-07
     * @datetime 2016-12-07T16:41:11-0500
     * @return   [type]                   [description]
     */
    public function getSaleNotesReazons(){

        $id = $this->request->data['id'];

        $saleNote = $this->SaleNotes->find('all',
            ['contain'=>['Bills.BillDetails','Bills.Payments'],
             'conditions'=>['SaleNotes.bills_id'=>$id]])->first();

        if($saleNote){
            $success = true;

            $this->set(compact('success','saleNote'));
        }else{

            $success = false;

            $errors = $saleNote->errors();

            $this->set(compact('success','errors'));

        }
    }
}
