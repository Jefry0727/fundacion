<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MedicalOffices Controller
 *
 * @property \App\Model\Table\MedicalOfficesTable $MedicalOffices
 */
class MedicalOfficesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $medicalOffices = $this->paginate($this->MedicalOffices);

        $this->set(compact('medicalOffices'));
        $this->set('_serialize', ['medicalOffices']);
    }



    /**
     * View method
     *
     * @param string|null $id Medical Office id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $medicalOffice = $this->MedicalOffices->get($id, [
            'contain' => []
        ]);

        $this->set('medicalOffice', $medicalOffice);
        $this->set('_serialize', ['medicalOffice']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $medicalOffice = $this->MedicalOffices->newEntity();

        $medicalOffice = $this->MedicalOffices->patchEntity($medicalOffice, $this->request->data);
            
        if ($this->MedicalOffices->save($medicalOffice)) {
            
            $this->Flash->success(__('The medical office has been saved.'));
            
            // return $this->redirect(['action' => 'index']);
            
            $success = true;

        } else {
            
            // $this->Flash->error(__('The medical office could not be saved. Please, try again.'));
            
            $success = false;
        
        }
 
        $this->set(compact('success','medicalOffice'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Medical Office id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {   
        $id = $this->request->data['id'];

        $medicalOffice = $this->MedicalOffices->get($id, [
            'contain' => []
        ]);

        $medicalOffice = $this->MedicalOffices->patchEntity($medicalOffice, $this->request->data);
            
        if ($this->MedicalOffices->save($medicalOffice)) {
        
            $success = true;

        } else {
                
            $success = false;
                     
        }

        $this->set(compact('success','medicalOffice'));
        
    }

    /**
     * Delete method
     *
     * @param string|null $id Medical Office id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
            
        $id = $this->request->data['id'];


        $medicalOffice = $this->MedicalOffices->get($id);
        
        if ($this->MedicalOffices->delete($medicalOffice)) {
        
            $success = true;
        
        } else {
        
            $success = false;
        
        }

        $this->set(compact('success','medicalOffice'));
    }


   /**
    * Consulta los consultorios activos en sede seleccionada
    * @return [type] [description]
    */
   public function getMedicalByCenter(){

    $data = $this->request->data;

    $idCenter = $data['id'];

    $medicalOffices = $this->MedicalOffices->find('all',
            ['conditions'=>[
                'MedicalOffices.centers_id'=> $idCenter,
                'MedicalOffices.state' => 1]
            ]);
     
     if ($medicalOffices) {
        
            $success = true;

            $this->set(compact('success','medicalOffices'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
   }

    /**
     * get Data from medical offices
     */
    public function getPaginMedicalOffices(){



        $data = $this->request->data;
        
        
        $offset = $data['offset'];

      //  $medicalOffices = $this->MedicalOffices->find('all', ['limit' => 10,'offset'=> $offset]);

        $medicalOffices = $this->MedicalOffices->find('all')->toArray();
        
        $total = $this->MedicalOffices->find('all')->count();
        
        if ($medicalOffices) {
        
            $success = true;

            $this->set(compact('success','medicalOffices','total'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }


    }

    /**
     * Get all the specializations in the proyect
     * @return [type] [description]
     */
      public function getMedicalOffice(){

        $medicalOffice = $this->MedicalOffices->find('all')->toArray();

         if ($medicalOffice) {
        
            $success = true;

            $this->set(compact('success','medicalOffice'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
        
    }


    public function setState(){

        $data = $this->request->data;

        $id = $data['id'];

        $medicalOffice = $this->MedicalOffices->get($id);

        $medicalOffice = $this->MedicalOffices->patchEntity($medicalOffice, $data);
            
        if ($this->MedicalOffices->save($medicalOffice)) {
        
            $success = true;

        } else {
                
            $success = false;
                     
        }

        $this->set(compact('success','medicalOffice'));



    }


}






