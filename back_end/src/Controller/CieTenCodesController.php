<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CieTenCodes Controller
 *
 * @property \App\Model\Table\CieTenCodesTable $CieTenCodes
 */
class CieTenCodesController extends AppController
{   

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['queryDiagnostic']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $cieTenCodes = $this->paginate($this->CieTenCodes);

        $this->set(compact('cieTenCodes'));
        $this->set('_serialize', ['cieTenCodes']);
    }

    /**
     * View method
     *
     * @param string|null $id Cie Ten Code id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cieTenCode = $this->CieTenCodes->get($id, [
            'contain' => []
        ]);

        $this->set('cieTenCode', $cieTenCode);
        $this->set('_serialize', ['cieTenCode']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cieTenCode = $this->CieTenCodes->newEntity();
        if ($this->request->is('post')) {
            $cieTenCode = $this->CieTenCodes->patchEntity($cieTenCode, $this->request->data);
            if ($this->CieTenCodes->save($cieTenCode)) {
                $this->Flash->success(__('The cie ten code has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cie ten code could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('cieTenCode'));
        $this->set('_serialize', ['cieTenCode']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cie Ten Code id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cieTenCode = $this->CieTenCodes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cieTenCode = $this->CieTenCodes->patchEntity($cieTenCode, $this->request->data);
            if ($this->CieTenCodes->save($cieTenCode)) {
                $this->Flash->success(__('The cie ten code has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cie ten code could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('cieTenCode'));
        $this->set('_serialize', ['cieTenCode']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cie Ten Code id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cieTenCode = $this->CieTenCodes->get($id);
        if ($this->CieTenCodes->delete($cieTenCode)) {
            $this->Flash->success(__('The cie ten code has been deleted.'));
        } else {
            $this->Flash->error(__('The cie ten code could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Función que se encarga de buscar los diagnosticos por codigo o por nombre
     * @return [type] [description]
     */
    public function queryDiagnostic($term){

        $this->autoRender = false;

        /**
         * busca por nombre y codigo
         * @var Int
         */
        if(!is_numeric($term)){

            $services = $this->CieTenCodes->find('all',['conditions'=>["CONCAT(CieTenCodes.description,CieTenCodes.code) like '%".$term."%' "],
                'limit' => 10
                ]);
           
        }else{

             
            $services = false;

        }
        
            echo json_encode(Array('servicesDiagnostic'=>$services));


        // $this->set(compact('services'));

    }
}
