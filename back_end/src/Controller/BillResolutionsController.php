<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BillResolutions Controller
 *
 * @property \App\Model\Table\BillResolutionsTable $BillResolutions
 */
class BillResolutionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ResolutionConcepts', 'BillTypes']
        ];
        $billResolutions = $this->paginate($this->BillResolutions);

        $this->set(compact('billResolutions'));
        $this->set('_serialize', ['billResolutions']);
    }

    /**
     * View method
     *
     * @param string|null $id Bill Resolution id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $billResolution = $this->BillResolutions->get($id, [
            'contain' => ['ResolutionConcepts', 'BillTypes']
        ]);

        $this->set('billResolution', $billResolution);
        $this->set('_serialize', ['billResolution']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $billResolution = $this->BillResolutions->newEntity();
        if ($this->request->is('post')) {
            $billResolution = $this->BillResolutions->patchEntity($billResolution, $this->request->data);
            if ($this->BillResolutions->save($billResolution)) {
                $this->Flash->success(__('The bill resolution has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bill resolution could not be saved. Please, try again.'));
            }
        }
        $resolutionConcepts = $this->BillResolutions->ResolutionConcepts->find('list', ['limit' => 200]);
        $billTypes = $this->BillResolutions->BillTypes->find('list', ['limit' => 200]);
        $this->set(compact('billResolution', 'resolutionConcepts', 'billTypes'));
        $this->set('_serialize', ['billResolution']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Bill Resolution id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $billResolution = $this->BillResolutions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $billResolution = $this->BillResolutions->patchEntity($billResolution, $this->request->data);
            if ($this->BillResolutions->save($billResolution)) {
                $this->Flash->success(__('The bill resolution has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bill resolution could not be saved. Please, try again.'));
            }
        }
        $resolutionConcepts = $this->BillResolutions->ResolutionConcepts->find('list', ['limit' => 200]);
        $billTypes = $this->BillResolutions->BillTypes->find('list', ['limit' => 200]);
        $this->set(compact('billResolution', 'resolutionConcepts', 'billTypes'));
        $this->set('_serialize', ['billResolution']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Bill Resolution id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $billResolution = $this->BillResolutions->get($id);
        if ($this->BillResolutions->delete($billResolution)) {
            $this->Flash->success(__('The bill resolution has been deleted.'));
        } else {
            $this->Flash->error(__('The bill resolution could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function getResolutionBill($centro, $tipo){
        
        if(is_array($centro)){
            $centro = $centro['id'];
        }

        $billResolutions = $this->BillResolutions->find('all', [
            'conditions'=>[
                'bill_types_id'=>$tipo, 
                'center_id'=>$centro, 
                'date_expedition <'=>date('Y-m-d')]
                ])->toArray();

        $billResolutions = $billResolutions[0];

        

        if(empty($billResolutions)){
            
            $success= false;
            $this->set(compact('success', 'billResolutions'));
        
            return "no se obtuvo ningun resultado"; 

        }
        else{
            
            $success = true;
            $resolution = 
                "RES. DIAN Nº " . $billResolutions['resolution'] . " DEL " . $billResolutions['date_expedition'] .
                " AUTORIZADA DEL " . $billResolutions['prefix'] . " " . $billResolutions['ini'] . " - " . 
                $billResolutions['prefix'] . " " . $billResolutions['end'];

            $this->set(compact('success', 'resolution'));

            return $resolution;
        }
    }
}
