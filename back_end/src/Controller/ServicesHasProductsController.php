<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ServicesHasProducts Controller
 *
 * @property \App\Model\Table\ServicesHasProductsTable $ServicesHasProducts
 */
class ServicesHasProductsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Services', 'Products']
        ];
        $servicesHasProducts = $this->paginate($this->ServicesHasProducts);

        $this->set(compact('servicesHasProducts'));
        $this->set('_serialize', ['servicesHasProducts']);
    }

    /**
     * View method
     *
     * @param string|null $id Services Has Product id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $servicesHasProduct = $this->ServicesHasProducts->get($id, [
            'contain' => ['Services', 'Products']
        ]);

        $this->set('servicesHasProduct', $servicesHasProduct);
        $this->set('_serialize', ['servicesHasProduct']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $servicesHasProduct = $this->ServicesHasProducts->newEntity();
        if ($this->request->is('post')) {
            $servicesHasProduct = $this->ServicesHasProducts->patchEntity($servicesHasProduct, $this->request->data);
            if ($this->ServicesHasProducts->save($servicesHasProduct)) {
                $this->Flash->success(__('The services has product has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The services has product could not be saved. Please, try again.'));
            }
        }
        $services = $this->ServicesHasProducts->Services->find('list', ['limit' => 200]);
        $products = $this->ServicesHasProducts->Products->find('list', ['limit' => 200]);
        $this->set(compact('servicesHasProduct', 'services', 'products'));
        $this->set('_serialize', ['servicesHasProduct']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Services Has Product id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $servicesHasProduct = $this->ServicesHasProducts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $servicesHasProduct = $this->ServicesHasProducts->patchEntity($servicesHasProduct, $this->request->data);
            if ($this->ServicesHasProducts->save($servicesHasProduct)) {
                $this->Flash->success(__('The services has product has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The services has product could not be saved. Please, try again.'));
            }
        }
        $services = $this->ServicesHasProducts->Services->find('list', ['limit' => 200]);
        $products = $this->ServicesHasProducts->Products->find('list', ['limit' => 200]);
        $this->set(compact('servicesHasProduct', 'services', 'products'));
        $this->set('_serialize', ['servicesHasProduct']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Services Has Product id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $servicesHasProduct = $this->ServicesHasProducts->get($id);
        if ($this->ServicesHasProducts->delete($servicesHasProduct)) {
            $this->Flash->success(__('The services has product has been deleted.'));
        } else {
            $this->Flash->error(__('The services has product could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
