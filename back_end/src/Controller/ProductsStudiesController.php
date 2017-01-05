<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProductsStudies Controller
 *
 * @property \App\Model\Table\ProductsStudiesTable $ProductsStudies
 */
class ProductsStudiesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products', 'Studies']
        ];
        $productsStudies = $this->paginate($this->ProductsStudies);

        $this->set(compact('productsStudies'));
        $this->set('_serialize', ['productsStudies']);
    }

    /**
     * View method
     *
     * @param string|null $id Products Study id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productsStudy = $this->ProductsStudies->get($id, [
            'contain' => ['Products', 'Studies']
        ]);

        $this->set('productsStudy', $productsStudy);
        $this->set('_serialize', ['productsStudy']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productsStudy = $this->ProductsStudies->newEntity();
        if ($this->request->is('post')) {
            $productsStudy = $this->ProductsStudies->patchEntity($productsStudy, $this->request->data);
            if ($this->ProductsStudies->save($productsStudy)) {
                $this->Flash->success(__('The products study has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The products study could not be saved. Please, try again.'));
            }
        }
        $products = $this->ProductsStudies->Products->find('list', ['limit' => 200]);
        $studies = $this->ProductsStudies->Studies->find('list', ['limit' => 200]);
        $this->set(compact('productsStudy', 'products', 'studies'));
        $this->set('_serialize', ['productsStudy']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Products Study id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productsStudy = $this->ProductsStudies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productsStudy = $this->ProductsStudies->patchEntity($productsStudy, $this->request->data);
            if ($this->ProductsStudies->save($productsStudy)) {
                $this->Flash->success(__('The products study has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The products study could not be saved. Please, try again.'));
            }
        }
        $products = $this->ProductsStudies->Products->find('list', ['limit' => 200]);
        $studies = $this->ProductsStudies->Studies->find('list', ['limit' => 200]);
        $this->set(compact('productsStudy', 'products', 'studies'));
        $this->set('_serialize', ['productsStudy']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Products Study id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productsStudy = $this->ProductsStudies->get($id);
        if ($this->ProductsStudies->delete($productsStudy)) {
            $this->Flash->success(__('The products study has been deleted.'));
        } else {
            $this->Flash->error(__('The products study could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
