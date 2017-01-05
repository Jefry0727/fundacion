<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\ORM\TableRegistry;

require(ROOT . DS . 'src' . DS . 'Controller' . DS . 'AppointmentsController.php');


/**
 * CancelBills Controller
 *
 * @property \App\Model\Table\CancelBillsTable $CancelBills
 */
class CancelBillsController extends AppController
{



  public function initialize()
  {
    parent::initialize();

    $this->Auth->allow(['prevBill','downloadPrev','getBillNumer','getBillsByDate']);

}



    /**
     * Index method
     */
    public function index()
    {
        $this->paginate = [
        'contain' => ['Bills']
        ];
        $cancelBills = $this->paginate($this->CancelBills);

        $this->set(compact('cancelBills'));
        $this->set('_serialize', ['cancelBills']);
    }

    /**
     * View method
     *
     * @param string|null $id Cancel Bill id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cancelBill = $this->CancelBills->get($id, [
            'contain' => ['Bills']
            ]);

        $this->set('cancelBill', $cancelBill);
        $this->set('_serialize', ['cancelBill']);
    }

   

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cancelBill = $this->CancelBills->get($id);
        if ($this->CancelBills->delete($cancelBill)) {
            $this->Flash->success(__('The cancel bill has been deleted.'));
        } else {
            $this->Flash->error(__('The cancel bill could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    /**
     * Cancel Bill, Update Bill Register.
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-07
     * @datetime 2016-12-07T16:31:46-0500
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function cancelUpdateBill($id){

        $this->loadModel('Bills');

        $editBill = $this->Bills->get($id);

        $editBill['canceled'] = 1;

        $editBill = $this->Bills->patchEntity($editBill, $editBill);

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
     * Insert Cancel Bill Reazons
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-07
     * @datetime 2016-12-07T16:31:59-0500
     * @return   [type]                   [description]
     */
    public function cancelBill(){
        $data = $this->request->data;
     
        $id = $data['bills_id'];

        // pr( $this->requestAction(
        //             array('controller' => 'Bills', 'action' => 'cancelBill'),
        //             array('pass' => array($id))
        //         ));
        
        $cancel = $this->cancelUpdateBill($id);

        $cancelBill = $this->CancelBills->newEntity();

     

        $cancelBill = $this->CancelBills->patchEntity($cancelBill, $this->request->data);
    
        $cancelBill['users_id']  = $this->Auth->user('id');

        if ($this->CancelBills->save($cancelBill)) {

            $success = true;

            $this->set(compact('success','cancelBill'));

        } else {

            $success = false;

            $errors = $cancelBill->errors();

            $this->set(compact('success','errors'));

        }

    }




    /**
     * get Details by cancel Reazons.
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-07
     * @datetime 2016-12-07T16:32:41-0500
     * @return   [type]                   [description]
     */
    public function getCancelReazons(){

        $id = $this->request->data['id'];

        $cancelBill = $this->CancelBills->find('all',['conditions'=>['CancelBills.bills_id'=>$id]])->first();

        if($cancelBill){
            $success = true;

            $this->set(compact('success','cancelBill'));
        }else{

            $success = false;

            $errors = $cancelBill->errors();

            $this->set(compact('success','errors'));

        }
    }
    
}
