<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BillTypes Controller
 *
 * @property \App\Model\Table\BillTypesTable $BillTypes
 */
class BillTypesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $billTypes = $this->paginate($this->BillTypes);

        $this->set(compact('billTypes'));
        $this->set('_serialize', ['billTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Bill Type id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $billType = $this->BillTypes->get($id, [
            'contain' => []
        ]);

        $this->set('billType', $billType);
        $this->set('_serialize', ['billType']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $billType = $this->BillTypes->newEntity();
        if ($this->request->is('post')) {
            $billType = $this->BillTypes->patchEntity($billType, $this->request->data);
            if ($this->BillTypes->save($billType)) {
                $this->Flash->success(__('The bill type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bill type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('billType'));
        $this->set('_serialize', ['billType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Bill Type id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $billType = $this->BillTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $billType = $this->BillTypes->patchEntity($billType, $this->request->data);
            if ($this->BillTypes->save($billType)) {
                $this->Flash->success(__('The bill type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bill type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('billType'));
        $this->set('_serialize', ['billType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Bill Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $billType = $this->BillTypes->get($id);
        if ($this->BillTypes->delete($billType)) {
            $this->Flash->success(__('The bill type has been deleted.'));
        } else {
            $this->Flash->error(__('The bill type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Typos de factura
     */
    public function getBilltypes(){


        $billTypes = $this->BillTypes->find('all')->toArray();

        $this->set(compact('billTypes'));


    }


}
