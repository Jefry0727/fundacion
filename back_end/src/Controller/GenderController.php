<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Gender Controller
 *
 * @property \App\Model\Table\GenderTable $Gender
 */
class GenderController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $gender = $this->paginate($this->Gender);

        $this->set(compact('gender'));
        $this->set('_serialize', ['gender']);
    }

    /**
     * View method
     *
     * @param string|null $id Gender id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $gender = $this->Gender->get($id, [
            'contain' => []
        ]);

        $this->set('gender', $gender);
        $this->set('_serialize', ['gender']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $gender = $this->Gender->newEntity();
        if ($this->request->is('post')) {
            $gender = $this->Gender->patchEntity($gender, $this->request->data);
            if ($this->Gender->save($gender)) {
                $this->Flash->success(__('The gender has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The gender could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('gender'));
        $this->set('_serialize', ['gender']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Gender id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $gender = $this->Gender->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gender = $this->Gender->patchEntity($gender, $this->request->data);
            if ($this->Gender->save($gender)) {
                $this->Flash->success(__('The gender has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The gender could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('gender'));
        $this->set('_serialize', ['gender']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Gender id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gender = $this->Gender->get($id);
        if ($this->Gender->delete($gender)) {
            $this->Flash->success(__('The gender has been deleted.'));
        } else {
            $this->Flash->error(__('The gender could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function getAllGener(){

        $gender = $this->Gender->find('all')->toArray();
       
        if($gender){
            $success = true;
             $this->set( compact( 'success', 'gender' ) );
        
        
        }else {
           $success = false;
           $error = $this->gender->errors();
            $this->set( compact( 'success', 'error' ) );
        
        }
    }
}
