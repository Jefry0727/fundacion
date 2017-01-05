<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FormPayments Controller
 *
 * @property \App\Model\Table\FormPaymentsTable $FormPayments
 */
class FormPaymentsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['getFormPayments']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $formPayments = $this->paginate($this->FormPayments);

        $this->set(compact('formPayments'));
        $this->set('_serialize', ['formPayments']);
    }

    /**
     * View method
     *
     * @param string|null $id Form Payment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $formPayment = $this->FormPayments->get($id, [
            'contain' => ['OrderDetails']
        ]);

        $this->set('formPayment', $formPayment);
        $this->set('_serialize', ['formPayment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $formPayment = $this->FormPayments->newEntity();
        if ($this->request->is('post')) {
            $formPayment = $this->FormPayments->patchEntity($formPayment, $this->request->data);
            if ($this->FormPayments->save($formPayment)) {
                $this->Flash->success(__('The form payment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The form payment could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('formPayment'));
        $this->set('_serialize', ['formPayment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Form Payment id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $formPayment = $this->FormPayments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formPayment = $this->FormPayments->patchEntity($formPayment, $this->request->data);
            if ($this->FormPayments->save($formPayment)) {
                $this->Flash->success(__('The form payment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The form payment could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('formPayment'));
        $this->set('_serialize', ['formPayment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Form Payment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $formPayment = $this->FormPayments->get($id);
        if ($this->FormPayments->delete($formPayment)) {
            $this->Flash->success(__('The form payment has been deleted.'));
        } else {
            $this->Flash->error(__('The form payment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Get Method
     */

    public function getFormPayments()
    {
        $formPayment = $this->FormPayments->find('all')->toArray();

        if($formPayment)
        {
            $success = true;

            $this->set(compact('success', 'formPayment'));
        }else{

            $success = false;

            $this->set(compact('success'));

        }
    }
}
