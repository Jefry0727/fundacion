<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Bills\cancellBill;

/**
 * NullsBills Controller
 *
 * @property \App\Model\Table\NullsBillsTable $NullsBills
 */
class NullsBillsController extends AppController
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
        $nullsBills = $this->paginate($this->NullsBills);

        $this->set(compact('nullsBills'));
        $this->set('_serialize', ['nullsBills']);
    }

    /**
     * View method
     *
     * @param string|null $id Nulls Bill id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $nullsBill = $this->NullsBills->get($id, [
            'contain' => ['Bills']
        ]);

        $this->set('nullsBill', $nullsBill);
        $this->set('_serialize', ['nullsBill']);
    }

  

    /**
     * Edit method
     *
     * @param string|null $id Nulls Bill id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $nullsBill = $this->NullsBills->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $nullsBill = $this->NullsBills->patchEntity($nullsBill, $this->request->data);
            if ($this->NullsBills->save($nullsBill)) {
                $this->Flash->success(__('The nulls bill has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The nulls bill could not be saved. Please, try again.'));
            }
        }
        $bills = $this->NullsBills->Bills->find('list', ['limit' => 200]);
        $this->set(compact('nullsBill', 'bills'));
        $this->set('_serialize', ['nullsBill']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Nulls Bill id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $nullsBill = $this->NullsBills->get($id);
        if ($this->NullsBills->delete($nullsBill)) {
            $this->Flash->success(__('The nulls bill has been deleted.'));
        } else {
            $this->Flash->error(__('The nulls bill could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    public function save(){

        $data = $this->request->data;

        $nullsBill = $this->NullsBills->newEntity();

        $nullsBill = $this->NullsBills->patchEntity($nullsBill, $this->request->data);

        if ($this->NullsBills->save($nullsBill)) {
                
             $success = true;

             $this->requestAction(
                    array('controller' => 'Bills', 'action' => 'cancellBill'),
                    array('pass' => array($data['bills_id']))
                );

            $this->set(compact('success','nullsBill'));

        } else {

            $success = false;

            $errors = $nullsBill->errors();

            $this->set(compact('success','errors'));

        }

    }
}

