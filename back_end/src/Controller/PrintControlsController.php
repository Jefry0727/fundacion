<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PrintControls Controller
 *
 * @property \App\Model\Table\PrintControlsTable $PrintControls
 */
class PrintControlsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Results', 'Users']
        ];
        $printControls = $this->paginate($this->PrintControls);

        $this->set(compact('printControls'));
        $this->set('_serialize', ['printControls']);
    }

    /**
     * View method
     *
     * @param string|null $id Print Control id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $printControl = $this->PrintControls->get($id, [
            'contain' => ['Results', 'Users']
        ]);

        $this->set('printControl', $printControl);
        $this->set('_serialize', ['printControl']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $printControl = $this->PrintControls->newEntity();
        if ($this->request->is('post')) {
            $printControl = $this->PrintControls->patchEntity($printControl, $this->request->data);
            if ($this->PrintControls->save($printControl)) {
                $this->Flash->success(__('The print control has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The print control could not be saved. Please, try again.'));
            }
        }
        $results = $this->PrintControls->Results->find('list', ['limit' => 200]);
        $users = $this->PrintControls->Users->find('list', ['limit' => 200]);
        $this->set(compact('printControl', 'results', 'users'));
        $this->set('_serialize', ['printControl']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Print Control id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $printControl = $this->PrintControls->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $printControl = $this->PrintControls->patchEntity($printControl, $this->request->data);
            if ($this->PrintControls->save($printControl)) {
                $this->Flash->success(__('The print control has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The print control could not be saved. Please, try again.'));
            }
        }
        $results = $this->PrintControls->Results->find('list', ['limit' => 200]);
        $users = $this->PrintControls->Users->find('list', ['limit' => 200]);
        $this->set(compact('printControl', 'results', 'users'));
        $this->set('_serialize', ['printControl']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Print Control id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $printControl = $this->PrintControls->get($id);
        if ($this->PrintControls->delete($printControl)) {
            $this->Flash->success(__('The print control has been deleted.'));
        } else {
            $this->Flash->error(__('The print control could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    public function getPrintNumber(){

        $idResult = $this->request->data['id'];

        $number = $this->PrintControls->find('all',
            ['conditions'=>['PrintControls.results_id' => $idResult]])->count();
       
        if ($number) {
        
            $success = true;

            $this->set(compact('success','number'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }

    }

    public function addPrintControl(){

        $printControl = $this->PrintControls->newEntity();

        $printControl['users_id'] = $this->Auth->user('id');

        $printControl = $this->PrintControls->patchEntity($printControl, $this->request->data);
      
        
        if ($this->PrintControls->save($printControl)) {
        
            $success = true;

            $this->set(compact('success','printControl'));

        } else {

            $success = false;

            $errors = $printControl->errors();         
    
            $this->set(compact('success','errors'));
        
        }
        
    }
}
