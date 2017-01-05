<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UserCenters Controller
 *
 * @property \App\Model\Table\UserCentersTable $UserCenters
 */
class UserCentersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Centers']
        ];
        $userCenters = $this->paginate($this->UserCenters);

        $this->set(compact('userCenters'));
        $this->set('_serialize', ['userCenters']);
    }

    /**
     * View method
     *
     * @param string|null $id User Center id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userCenter = $this->UserCenters->get($id, [
            'contain' => ['Users', 'Centers']
        ]);

        $this->set('userCenter', $userCenter);
        $this->set('_serialize', ['userCenter']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userCenter = $this->UserCenters->newEntity();
        if ($this->request->is('post')) {
            $userCenter = $this->UserCenters->patchEntity($userCenter, $this->request->data);
            if ($this->UserCenters->save($userCenter)) {
                $this->Flash->success(__('The user center has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user center could not be saved. Please, try again.'));
            }
        }
        $users = $this->UserCenters->Users->find('list', ['limit' => 200]);
        $centers = $this->UserCenters->Centers->find('list', ['limit' => 200]);
        $this->set(compact('userCenter', 'users', 'centers'));
        $this->set('_serialize', ['userCenter']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User Center id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userCenter = $this->UserCenters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userCenter = $this->UserCenters->patchEntity($userCenter, $this->request->data);
            if ($this->UserCenters->save($userCenter)) {
                $this->Flash->success(__('The user center has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user center could not be saved. Please, try again.'));
            }
        }
        $users = $this->UserCenters->Users->find('list', ['limit' => 200]);
        $centers = $this->UserCenters->Centers->find('list', ['limit' => 200]);
        $this->set(compact('userCenter', 'users', 'centers'));
        $this->set('_serialize', ['userCenter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User Center id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userCenter = $this->UserCenters->get($id);
        if ($this->UserCenters->delete($userCenter)) {
            $this->Flash->success(__('The user center has been deleted.'));
        } else {
            $this->Flash->error(__('The user center could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
