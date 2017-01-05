<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tacs Controller
 *
 * @property \App\Model\Table\TacsTable $Tacs
 */
class TacsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $tacs = $this->paginate($this->Tacs);

        $this->set(compact('tacs'));
        $this->set('_serialize', ['tacs']);
    }

    /**
     * View method
     *
     * @param string|null $id Tac id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tac = $this->Tacs->get($id, [
            'contain' => []
        ]);

        $this->set('tac', $tac);
        $this->set('_serialize', ['tac']);
    }

   
    




    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addTacs()
    {
       
        
        $data = $this->request->data;

        // // obtener ultimo registro consecutivo 
        // $lastCode = $this->Tacs->find('all',
        //     ['conditions'=>['Tacs.format_consec =(SELECT MAX(Tacs.format_consec) FORM tacs)']]);


        $code ='TAC'.$this->Tacs->find('all')->count();

        $data['format_consec'] = $code;

        $data['users_id'] = $this->Auth->user('id');

        // if($data['users_id'] == null){

        //     $data['users_id'] = 1;

        // } 

        $tacs = $this->Tacs->newEntity();

        $tacs = $this->Tacs->patchEntity($tacs, $data);

        if ($this->Tacs->save($tacs)) {

            $success = true;  
             
            $this->set(compact('success','result'));

        }else {

            $success = false;

            $errors = $tacs->errors();

            $this->set(compact('success','errors'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Tac id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tac = $this->Tacs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tac = $this->Tacs->patchEntity($tac, $this->request->data);
            if ($this->Tacs->save($tac)) {
                $this->Flash->success(__('The tac has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The tac could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('tac'));
        $this->set('_serialize', ['tac']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tac id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tac = $this->Tacs->get($id);
        if ($this->Tacs->delete($tac)) {
            $this->Flash->success(__('The tac has been deleted.'));
        } else {
            $this->Flash->error(__('The tac could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
