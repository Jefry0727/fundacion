<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RipDescripcion Controller
 *
 * @property \App\Model\Table\RipDescripcionTable $RipDescripcion
 */
class RipDescripcionController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $ripDescripcion = $this->paginate($this->RipDescripcion);

        $this->set(compact('ripDescripcion'));
        $this->set('_serialize', ['ripDescripcion']);
    }

    /**
     * View method
     *
     * @param string|null $id Rip Descripcion id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ripDescripcion = $this->RipDescripcion->get($id, [
            'contain' => []
        ]);

        $this->set('ripDescripcion', $ripDescripcion);
        $this->set('_serialize', ['ripDescripcion']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ripDescripcion = $this->RipDescripcion->newEntity();
        if ($this->request->is('post')) {
            $ripDescripcion = $this->RipDescripcion->patchEntity($ripDescripcion, $this->request->data);
            if ($this->RipDescripcion->save($ripDescripcion)) {
                $this->Flash->success(__('The rip descripcion has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rip descripcion could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ripDescripcion'));
        $this->set('_serialize', ['ripDescripcion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rip Descripcion id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ripDescripcion = $this->RipDescripcion->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ripDescripcion = $this->RipDescripcion->patchEntity($ripDescripcion, $this->request->data);
            if ($this->RipDescripcion->save($ripDescripcion)) {
                $this->Flash->success(__('The rip descripcion has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rip descripcion could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ripDescripcion'));
        $this->set('_serialize', ['ripDescripcion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rip Descripcion id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ripDescripcion = $this->RipDescripcion->get($id);
        if ($this->RipDescripcion->delete($ripDescripcion)) {
            $this->Flash->success(__('The rip descripcion has been deleted.'));
        } else {
            $this->Flash->error(__('The rip descripcion could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
