<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Specializations Controller
 *
 * @property \App\Model\Table\SpecializationsTable $Specializations
 */
class SpecializationsController extends AppController
{

public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add','edit','delete','index','get', 'allSpecialization']);
    }

    public function allSpecialization()
    {
        $specializations = $this->Specializations->find('all')->toArray();

        if($specializations)
        {
            $success = true;

            $this->set(compact('success', 'specializations'));
        }else{

            $success = false;

            $this->set(compact('success'));
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $specializations = $this->paginate($this->Specializations);

        $this->set(compact('specializations'));
        $this->set('_serialize', ['specializations']);
    }

    /**
     * Get all the specializations in the proyect
     * @return [type] [description]
     */
      public function get(){

        $data = $this->request->data;

        $idCenter  = $data['idCenter']; 

        $specialization = $this->Specializations->find('all',['conditions'=>['Specializations.cost_centers_id' => $idCenter]])->toArray();

         if ($specialization) {
        
            $success = true;

            $this->set(compact('success','specialization'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
        
    }


    /**
     * View method
     *
     * @param string|null $id Specialization id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $specialization = $this->Specializations->get($id, [
            'contain' => []
        ]);

        $this->set('specialization', $specialization);
        $this->set('_serialize', ['specialization']);
    }






    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $specialization = $this->Specializations->newEntity();
        if ($this->request->is('post')) {
            $specialization = $this->Specializations->patchEntity($specialization, $this->request->data);
            if ($this->Specializations->save($specialization)) {
                $this->Flash->success(__('The specialization has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The specialization could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('specialization'));
        $this->set('_serialize', ['specialization']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Specialization id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $specialization = $this->Specializations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $specialization = $this->Specializations->patchEntity($specialization, $this->request->data);
            if ($this->Specializations->save($specialization)) {
                $this->Flash->success(__('The specialization has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The specialization could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('specialization'));
        $this->set('_serialize', ['specialization']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Specialization id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $specialization = $this->Specializations->get($id);
        if ($this->Specializations->delete($specialization)) {
            $this->Flash->success(__('The specialization has been deleted.'));
        } else {
            $this->Flash->error(__('The specialization could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }



    public function getSpecializationsById(){
       $attentions_id = $this->request->data['attentions_id'];

       $respuesta = $this->Specializations->find('all', [
            'conditions'=>
            ['id IN '=>$attentions_id]
            ])->toArray();

       if($respuesta){
        $success= true;
        $this->set(compact('success', 'respuesta'));
       }else{
        $success= false;
        $this->set(compact('success', 'attentions_id'));
       }
    }

    public function getAllSpecializations()
    {
        $respuesta = $this->Specializations->find('all',['conditions'=>['Specializations.id >'=> 0] ])->toArray();


        if($respuesta){

            $success = true;

            $this->set(compact('success', 'respuesta'));

        }else{

            $success = false;

            $this->set(compact('success' ,'errors'));

        }
    }
}
