<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CostCenters Controller
 *
 * @property \App\Model\Table\CostCentersTable $CostCenters
 */
class CostCentersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $costCenters = $this->paginate($this->CostCenters);

        $this->set(compact('costCenters'));
        $this->set('_serialize', ['costCenters']);
    }

    /**
     * View method
     *
     * @param string|null $id Cost Center id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $costCenter = $this->CostCenters->get($id, [
            'contain' => []
        ]);

        $this->set('costCenter', $costCenter);
        $this->set('_serialize', ['costCenter']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $costCenter = $this->CostCenters->newEntity();
        if ($this->request->is('post')) {
            $costCenter = $this->CostCenters->patchEntity($costCenter, $this->request->data);
            if ($this->CostCenters->save($costCenter)) {
                $this->Flash->success(__('The cost center has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cost center could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('costCenter'));
        $this->set('_serialize', ['costCenter']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cost Center id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $costCenter = $this->CostCenters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $costCenter = $this->CostCenters->patchEntity($costCenter, $this->request->data);
            if ($this->CostCenters->save($costCenter)) {
                $this->Flash->success(__('The cost center has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cost center could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('costCenter'));
        $this->set('_serialize', ['costCenter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cost Center id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $costCenter = $this->CostCenters->get($id);
        if ($this->CostCenters->delete($costCenter)) {
            $this->Flash->success(__('The cost center has been deleted.'));
        } else {
            $this->Flash->error(__('The cost center could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }



      /**
     * Get all the CostCenters in the proyect
     * @return [type] [description]
     */
      public function get(){

        $costCenter = $this->CostCenters->find('all')->toArray();
         if ($costCenter) {
        
            $success = true;

            $this->set(compact('success','costCenter'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
        
    }

          /**
     * Get all the CostCenters in the proyect
     * @return [type] [description]
     */
      public function getSelectedCostCenters(){

        $data = $this->request->data;

        $costCenter = $this->CostCenters->find('all' , ['conditions'=>['CostCenters.id' => $data['id']]])->first();

         if ($costCenter) {
        
            $success = true;

            $this->set(compact('success','costCenter'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
        
    }
}
