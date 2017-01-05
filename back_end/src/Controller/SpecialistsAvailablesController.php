<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SpecialistsAvailables Controller
 *
 * @property \App\Model\Table\SpecialistsAvailablesTable $SpecialistsAvailables
 */
class SpecialistsAvailablesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Specialists', 'ServiceTypes']
        ];
        $specialistsAvailables = $this->paginate($this->SpecialistsAvailables);

        $this->set(compact('specialistsAvailables'));
        $this->set('_serialize', ['specialistsAvailables']);
    }

    /**
     * View method
     *
     * @param string|null $id Specialists Available id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $specialistsAvailable = $this->SpecialistsAvailables->get($id, [
            'contain' => ['Specialists', 'ServiceTypes']
        ]);

        $this->set('specialistsAvailable', $specialistsAvailable);
        $this->set('_serialize', ['specialistsAvailable']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $specialistsAvailable = $this->SpecialistsAvailables->newEntity();
        if ($this->request->is('post')) {
            $specialistsAvailable = $this->SpecialistsAvailables->patchEntity($specialistsAvailable, $this->request->data);
            if ($this->SpecialistsAvailables->save($specialistsAvailable)) {
                $this->Flash->success(__('The specialists available has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The specialists available could not be saved. Please, try again.'));
            }
        }
        $specialists = $this->SpecialistsAvailables->Specialists->find('list', ['limit' => 200]);
        $serviceTypes = $this->SpecialistsAvailables->ServiceTypes->find('list', ['limit' => 200]);
        $this->set(compact('specialistsAvailable', 'specialists', 'serviceTypes'));
        $this->set('_serialize', ['specialistsAvailable']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Specialists Available id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $specialistsAvailable = $this->SpecialistsAvailables->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $specialistsAvailable = $this->SpecialistsAvailables->patchEntity($specialistsAvailable, $this->request->data);
            if ($this->SpecialistsAvailables->save($specialistsAvailable)) {
                $this->Flash->success(__('The specialists available has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The specialists available could not be saved. Please, try again.'));
            }
        }
        $specialists = $this->SpecialistsAvailables->Specialists->find('list', ['limit' => 200]);
        $serviceTypes = $this->SpecialistsAvailables->ServiceTypes->find('list', ['limit' => 200]);
        $this->set(compact('specialistsAvailable', 'specialists', 'serviceTypes'));
        $this->set('_serialize', ['specialistsAvailable']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Specialists Available id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $specialistsAvailable = $this->SpecialistsAvailables->get($id);
        if ($this->SpecialistsAvailables->delete($specialistsAvailable)) {
            $this->Flash->success(__('The specialists available has been deleted.'));
        } else {
            $this->Flash->error(__('The specialists available could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
