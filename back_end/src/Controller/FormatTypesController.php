<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FormatTypes Controller
 *
 * @property \App\Model\Table\FormatTypesTable $FormatTypes
 */
class FormatTypesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $formatTypes = $this->paginate($this->FormatTypes);

        $this->set(compact('formatTypes'));
        $this->set('_serialize', ['formatTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Format Type id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $formatType = $this->FormatTypes->get($id, [
            'contain' => ['ControlFormats']
        ]);

        $this->set('formatType', $formatType);
        $this->set('_serialize', ['formatType']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $formatType = $this->FormatTypes->newEntity();
        if ($this->request->is('post')) {
            $formatType = $this->FormatTypes->patchEntity($formatType, $this->request->data);
            if ($this->FormatTypes->save($formatType)) {
                $this->Flash->success(__('The format type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The format type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('formatType'));
        $this->set('_serialize', ['formatType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Format Type id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $formatType = $this->FormatTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formatType = $this->FormatTypes->patchEntity($formatType, $this->request->data);
            if ($this->FormatTypes->save($formatType)) {
                $this->Flash->success(__('The format type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The format type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('formatType'));
        $this->set('_serialize', ['formatType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Format Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $formatType = $this->FormatTypes->get($id);
        if ($this->FormatTypes->delete($formatType)) {
            $this->Flash->success(__('The format type has been deleted.'));
        } else {
            $this->Flash->error(__('The format type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
