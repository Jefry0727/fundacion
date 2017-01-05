<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FarmaseuticForm Controller
 *
 * @property \App\Model\Table\FarmaseuticFormTable $FarmaseuticForm
 */
class FarmaseuticFormController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $farmaseuticForm = $this->paginate($this->FarmaseuticForm);

        $this->set(compact('farmaseuticForm'));
        $this->set('_serialize', ['farmaseuticForm']);
    }

    /**
     * View method
     *
     * @param string|null $id Farmaseutic Form id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $farmaseuticForm = $this->FarmaseuticForm->get($id, [
            'contain' => []
        ]);

        $this->set('farmaseuticForm', $farmaseuticForm);
        $this->set('_serialize', ['farmaseuticForm']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $farmaseuticForm = $this->FarmaseuticForm->newEntity();
        if ($this->request->is('post')) {
            $farmaseuticForm = $this->FarmaseuticForm->patchEntity($farmaseuticForm, $this->request->data);
            if ($this->FarmaseuticForm->save($farmaseuticForm)) {
                $this->Flash->success(__('The farmaseutic form has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The farmaseutic form could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('farmaseuticForm'));
        $this->set('_serialize', ['farmaseuticForm']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Farmaseutic Form id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $farmaseuticForm = $this->FarmaseuticForm->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $farmaseuticForm = $this->FarmaseuticForm->patchEntity($farmaseuticForm, $this->request->data);
            if ($this->FarmaseuticForm->save($farmaseuticForm)) {
                $this->Flash->success(__('The farmaseutic form has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The farmaseutic form could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('farmaseuticForm'));
        $this->set('_serialize', ['farmaseuticForm']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Farmaseutic Form id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $farmaseuticForm = $this->FarmaseuticForm->get($id);
        if ($this->FarmaseuticForm->delete($farmaseuticForm)) {
            $this->Flash->success(__('The farmaseutic form has been deleted.'));
        } else {
            $this->Flash->error(__('The farmaseutic form could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


        // Obtiene un listado de marcas.
    public function getAllFarmaseuticForm (){

           $farmaseuticForm = $this->FarmaseuticForm->find('all')->toArray();

        if($farmaseuticForm)
        {
            $success = true;

            $this->set(compact('success', 'farmaseuticForm'));
        }else{

            $success = false;

            $this->set(compact('success'));
        }
    }
}
