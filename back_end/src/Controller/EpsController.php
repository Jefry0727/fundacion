<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Eps Controller
 *
 * @property \App\Model\Table\EpsTable $Eps
 */
class EpsController extends AppController
{

     public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['getAllEps']);

    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $eps = $this->paginate($this->Eps);

        $this->set(compact('eps'));
        $this->set('_serialize', ['eps']);
    }

    /**
     * View method
     *
     * @param string|null $id Ep id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ep = $this->Eps->get($id, [
            'contain' => []
        ]);

        $this->set('ep', $ep);
        $this->set('_serialize', ['ep']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ep = $this->Eps->newEntity();
        if ($this->request->is('post')) {
            $ep = $this->Eps->patchEntity($ep, $this->request->data);
            if ($this->Eps->save($ep)) {
                $this->Flash->success(__('The ep has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ep could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ep'));
        $this->set('_serialize', ['ep']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ep id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ep = $this->Eps->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ep = $this->Eps->patchEntity($ep, $this->request->data);
            if ($this->Eps->save($ep)) {
                $this->Flash->success(__('The ep has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ep could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ep'));
        $this->set('_serialize', ['ep']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ep id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ep = $this->Eps->get($id);
        if ($this->Eps->delete($ep)) {
            $this->Flash->success(__('The ep has been deleted.'));
        } else {
            $this->Flash->error(__('The ep could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public  function getAllEps()
    {
        $eps = $this->Eps->find('all')->order(['Eps.name' => 'ASC'])->toArray();

        if($eps)
        {
            $success = true;

            $this->set(compact('success', 'eps'));
        }else{

            $success = false;

            $this->set(compact('success'));
        }
    }
}
