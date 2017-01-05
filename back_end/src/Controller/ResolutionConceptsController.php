<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ResolutionConcepts Controller
 *
 * @property \App\Model\Table\ResolutionConceptsTable $ResolutionConcepts
 */
class ResolutionConceptsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $resolutionConcepts = $this->paginate($this->ResolutionConcepts);

        $this->set(compact('resolutionConcepts'));
        $this->set('_serialize', ['resolutionConcepts']);
    }

    /**
     * View method
     *
     * @param string|null $id Resolution Concept id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $resolutionConcept = $this->ResolutionConcepts->get($id, [
            'contain' => []
        ]);

        $this->set('resolutionConcept', $resolutionConcept);
        $this->set('_serialize', ['resolutionConcept']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $resolutionConcept = $this->ResolutionConcepts->newEntity();
        if ($this->request->is('post')) {
            $resolutionConcept = $this->ResolutionConcepts->patchEntity($resolutionConcept, $this->request->data);
            if ($this->ResolutionConcepts->save($resolutionConcept)) {
                $this->Flash->success(__('The resolution concept has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The resolution concept could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('resolutionConcept'));
        $this->set('_serialize', ['resolutionConcept']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Resolution Concept id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $resolutionConcept = $this->ResolutionConcepts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resolutionConcept = $this->ResolutionConcepts->patchEntity($resolutionConcept, $this->request->data);
            if ($this->ResolutionConcepts->save($resolutionConcept)) {
                $this->Flash->success(__('The resolution concept has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The resolution concept could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('resolutionConcept'));
        $this->set('_serialize', ['resolutionConcept']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Resolution Concept id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $resolutionConcept = $this->ResolutionConcepts->get($id);
        if ($this->ResolutionConcepts->delete($resolutionConcept)) {
            $this->Flash->success(__('The resolution concept has been deleted.'));
        } else {
            $this->Flash->error(__('The resolution concept could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
