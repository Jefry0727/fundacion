<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Nuclear Controller
 *
 * @property \App\Model\Table\NuclearTable $Nuclear
 */
class NuclearController extends AppController
{   

     public function initialize()
    {
        parent::initialize();
        $this->Auth->allow([]);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ControlFormats']
        ];
        $nuclear = $this->paginate($this->Nuclear);

        $this->set(compact('nuclear'));
        $this->set('_serialize', ['nuclear']);
    }

    /**
     * View method
     *
     * @param string|null $id Nuclear id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $nuclear = $this->Nuclear->get($id, [
            'contain' => ['ControlFormats']
        ]);

        $this->set('nuclear', $nuclear);
        $this->set('_serialize', ['nuclear']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addNuclear()
    {
        $data = $this->request->data;

        $code ='NUC'.$this->Nuclear->find('all')->count();

        $data['format_consec'] = $code;

        $data['users_id'] = $this->Auth->user('id');

        // if($data['users_id'] == null){

        //     $data['users_id'] = 1;

        // }


        $nuclear = $this->Nuclear->newEntity();

        $nuclear = $this->Nuclear->patchEntity($nuclear, $data);

        if ($this->Nuclear->save($nuclear)) {

            $success = true;

            $this->set(compact('success', 'nuclear'));

        } else {

            $success = false;

            $errors = $nuclear->errors();

            $this->set(compact('success','errors'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Nuclear id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $nuclear = $this->Nuclear->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $nuclear = $this->Nuclear->patchEntity($nuclear, $this->request->data);
            if ($this->Nuclear->save($nuclear)) {
                $this->Flash->success(__('The nuclear has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The nuclear could not be saved. Please, try again.'));
            }
        }
        $controlFormats = $this->Nuclear->ControlFormats->find('list', ['limit' => 200]);
        $this->set(compact('nuclear', 'controlFormats'));
        $this->set('_serialize', ['nuclear']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Nuclear id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $nuclear = $this->Nuclear->get($id);
        if ($this->Nuclear->delete($nuclear)) {
            $this->Flash->success(__('The nuclear has been deleted.'));
        } else {
            $this->Flash->error(__('The nuclear could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
