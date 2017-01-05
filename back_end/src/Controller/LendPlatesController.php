<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LendPlates Controller
 *
 * @property \App\Model\Table\LendPlatesTable $LendPlates
 */
class LendPlatesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Delivereds', 'Attentions', 'Users']
        ];
        $lendPlates = $this->paginate($this->LendPlates);

        $this->set(compact('lendPlates'));
        $this->set('_serialize', ['lendPlates']);
    }

    /**
     * View method
     *
     * @param string|null $id Lend Plate id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lendPlate = $this->LendPlates->get($id, [
            'contain' => ['Delivereds', 'Attentions', 'Users']
        ]);

        $this->set('lendPlate', $lendPlate);
        $this->set('_serialize', ['lendPlate']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lendPlate = $this->LendPlates->newEntity();
        if ($this->request->is('post')) {
            $lendPlate = $this->LendPlates->patchEntity($lendPlate, $this->request->data);
            if ($this->LendPlates->save($lendPlate)) {
                $this->Flash->success(__('The lend plate has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The lend plate could not be saved. Please, try again.'));
            }
        }
        $delivereds = $this->LendPlates->Delivereds->find('list', ['limit' => 200]);
        $attentions = $this->LendPlates->Attentions->find('list', ['limit' => 200]);
        $users = $this->LendPlates->Users->find('list', ['limit' => 200]);
        $this->set(compact('lendPlate', 'delivereds', 'attentions', 'users'));
        $this->set('_serialize', ['lendPlate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lend Plate id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lendPlate = $this->LendPlates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lendPlate = $this->LendPlates->patchEntity($lendPlate, $this->request->data);
            if ($this->LendPlates->save($lendPlate)) {
                $this->Flash->success(__('The lend plate has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The lend plate could not be saved. Please, try again.'));
            }
        }
        $delivereds = $this->LendPlates->Delivereds->find('list', ['limit' => 200]);
        $attentions = $this->LendPlates->Attentions->find('list', ['limit' => 200]);
        $users = $this->LendPlates->Users->find('list', ['limit' => 200]);
        $this->set(compact('lendPlate', 'delivereds', 'attentions', 'users'));
        $this->set('_serialize', ['lendPlate']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lend Plate id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lendPlate = $this->LendPlates->get($id);
        if ($this->LendPlates->delete($lendPlate)) {
            $this->Flash->success(__('The lend plate has been deleted.'));
        } else {
            $this->Flash->error(__('The lend plate could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function addLend(){
       
        $lendPlate = $this->LendPlates->newEntity();

        $data =  $this->request->data;
        unset($data['id']);
        $data['users_id'] = $this->Auth->user('id');
        $data['returned'] = '0';
       
        $lendPlate = $this->LendPlates->patchEntity($lendPlate,$data);
        if ($this->LendPlates->save($lendPlate)) {

            $success = true;

             $this->set(compact('success','lendPlate'));
   
            } else {
              $success = false;

            $error = $lendPlate ->errors();         
    
            $this->set(compact('success','error'));
            }
        }

        public function getLendPlatesById(){
            $id = $this->request->data['attentions_id'];
            $lend_plate = $this->LendPlates->find('all', ['conditions'=>['LendPlates.attentions_id'=>$id]])->first();
            if($lend_plate){
                $success = true;
                $this->set(compact('success', 'lend_plate'));
            }
            else{
                $success = false;
                $this->set(compact('success'));
            }
        }

}
