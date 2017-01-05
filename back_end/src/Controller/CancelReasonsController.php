<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CancelReasons Controller


 * @property \App\Model\Table\CancelReasonsTable $CancelReasons
 */
class CancelReasonsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['save']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['AppointmentDates']
        ];
        $cancelReasons = $this->paginate($this->CancelReasons);

        $this->set(compact('cancelReasons'));
        $this->set('_serialize', ['cancelReasons']);
    }

    /**
     * View method
     *
     */
    public function view($id = null)
    {
        $cancelReason = $this->CancelReasons->get($id, [
            'contain' => ['AppointmentDates']
        ]);

        $this->set('cancelReason', $cancelReason);
        $this->set('_serialize', ['cancelReason']);
    }


    /**
     * Funcion que guarda por que se cancelo una CITA 
     * @return [type] [description]
     */
    public function cancelReasons(){

        $data = $this->request->data;

        $cancel = $this->CancelReasons->newEntity();

        $data['users_id'] = $this->Auth->user('id');

        $cancel = $this->CancelReasons->patchEntity($cancel, $data);


            if ($this->CancelReasons->save($cancel)) {

                $success = true;
                
                $this->set(compact('success','cancel'));

            } else {

                $success = false;

                $errors = $cancel->errors();

                $this->set(compact('success','errors'));

            }
           

        // $this->set(compact('date'));
        
    }

    /**
     * Delete method
     *
     * @param string|null $id Cancel Reason id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cancelReason = $this->CancelReasons->get($id);
        if ($this->CancelReasons->delete($cancelReason)) {
            $this->Flash->success(__('The cancel reason has been deleted.'));
        } else {
            $this->Flash->error(__('The cancel reason could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    /**
     * [save description]
     * @return [type] [description]
     */
    public function save(){

        $data = $this->request->data;

        $data['appointment_dates_id'] = 94;

        $cancelReason = $this->CancelReasons->newEntity();

        $cancelReason = $this->CancelReasons->patchEntity($cancelReason, $data);

        if ($this->CancelReasons->save($cancelReason)) {

            $success = true;

            $this->set(compact('success','cancelReason'));

        } else {

            $success = false;

            $errors = $cancelReason->errors();

            $this->set(compact('success','errors'));

        }




    }
}
