<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InvimaCodeProducts Controller
 *
 * @property \App\Model\Table\InvimaCodeProductsTable $InvimaCodeProducts
 */
class InvimaCodeProductsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products', 'InvimaCodes']
        ];
        $invimaCodeProducts = $this->paginate($this->InvimaCodeProducts);

        $this->set(compact('invimaCodeProducts'));
        $this->set('_serialize', ['invimaCodeProducts']);
    }

    /**
     * View method
     *
     * @param string|null $id Invima Code Product id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invimaCodeProduct = $this->InvimaCodeProducts->get($id, [
            'contain' => ['Products', 'InvimaCodes']
        ]);

        $this->set('invimaCodeProduct', $invimaCodeProduct);
        $this->set('_serialize', ['invimaCodeProduct']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $invimaCodeProduct = $this->InvimaCodeProducts->newEntity();
        if ($this->request->is('post')) {
            $invimaCodeProduct = $this->InvimaCodeProducts->patchEntity($invimaCodeProduct, $this->request->data);
            if ($this->InvimaCodeProducts->save($invimaCodeProduct)) {
                $this->Flash->success(__('The invima code product has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The invima code product could not be saved. Please, try again.'));
            }
        }
        $products = $this->InvimaCodeProducts->Products->find('list', ['limit' => 200]);
        $invimaCodes = $this->InvimaCodeProducts->InvimaCodes->find('list', ['limit' => 200]);
        $this->set(compact('invimaCodeProduct', 'products', 'invimaCodes'));
        $this->set('_serialize', ['invimaCodeProduct']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Invima Code Product id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invimaCodeProduct = $this->InvimaCodeProducts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invimaCodeProduct = $this->InvimaCodeProducts->patchEntity($invimaCodeProduct, $this->request->data);
            if ($this->InvimaCodeProducts->save($invimaCodeProduct)) {
                $this->Flash->success(__('The invima code product has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The invima code product could not be saved. Please, try again.'));
            }
        }
        $products = $this->InvimaCodeProducts->Products->find('list', ['limit' => 200]);
        $invimaCodes = $this->InvimaCodeProducts->InvimaCodes->find('list', ['limit' => 200]);
        $this->set(compact('invimaCodeProduct', 'products', 'invimaCodes'));
        $this->set('_serialize', ['invimaCodeProduct']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Invima Code Product id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invimaCodeProduct = $this->InvimaCodeProducts->get($id);
        if ($this->InvimaCodeProducts->delete($invimaCodeProduct)) {
            $this->Flash->success(__('The invima code product has been deleted.'));
        } else {
            $this->Flash->error(__('The invima code product could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
