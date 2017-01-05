<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * StudiesMedicalOffices Controller
 *
 * @property \App\Model\Table\StudiesMedicalOfficesTable $StudiesMedicalOffices
 */
class StudiesMedicalOfficesController extends AppController
{


    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['getMedicalOfficesServicesBySpecialization','getMedicalOfficesSpecializations']);
    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Studies', 'MedicalOffices']
        ];
        $studiesMedicalOffices = $this->paginate($this->StudiesMedicalOffices);

        $this->set(compact('studiesMedicalOffices'));
        $this->set('_serialize', ['studiesMedicalOffices']);
    }

    /**
     * View method
     *
     * @param string|null $id Studies Medical Office id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $studiesMedicalOffice = $this->StudiesMedicalOffices->get($id, [
            'contain' => ['Studies', 'MedicalOffices']
        ]);

        $this->set('studiesMedicalOffice', $studiesMedicalOffice);
        $this->set('_serialize', ['studiesMedicalOffice']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $studiesMedicalOffice = $this->StudiesMedicalOffices->newEntity();
        if ($this->request->is('post')) {
            $studiesMedicalOffice = $this->StudiesMedicalOffices->patchEntity($studiesMedicalOffice, $this->request->data);
            if ($this->StudiesMedicalOffices->save($studiesMedicalOffice)) {
                $this->Flash->success(__('The studies medical office has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The studies medical office could not be saved. Please, try again.'));
            }
        }
        $studies = $this->StudiesMedicalOffices->Studies->find('list', ['limit' => 200]);
        $medicalOffices = $this->StudiesMedicalOffices->MedicalOffices->find('list', ['limit' => 200]);
        $this->set(compact('studiesMedicalOffice', 'studies', 'medicalOffices'));
        $this->set('_serialize', ['studiesMedicalOffice']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Studies Medical Office id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $studiesMedicalOffice = $this->StudiesMedicalOffices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $studiesMedicalOffice = $this->StudiesMedicalOffices->patchEntity($studiesMedicalOffice, $this->request->data);
            if ($this->StudiesMedicalOffices->save($studiesMedicalOffice)) {
                $this->Flash->success(__('The studies medical office has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The studies medical office could not be saved. Please, try again.'));
            }
        }
        $studies = $this->StudiesMedicalOffices->Studies->find('list', ['limit' => 200]);
        $medicalOffices = $this->StudiesMedicalOffices->MedicalOffices->find('list', ['limit' => 200]);
        $this->set(compact('studiesMedicalOffice', 'studies', 'medicalOffices'));
        $this->set('_serialize', ['studiesMedicalOffice']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Studies Medical Office id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $studiesMedicalOffice = $this->StudiesMedicalOffices->get($id);
        if ($this->StudiesMedicalOffices->delete($studiesMedicalOffice)) {
            $this->Flash->success(__('The studies medical office has been deleted.'));
        } else {
            $this->Flash->error(__('The studies medical office could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }





    /**
     * Funcion que asigna los estudios seleccionados a un consultorio
     */
     public function addAll(){


            $studiesMedicalOffice = $this->request->data;

            $success = true;

            foreach($studiesMedicalOffice as $study){

                 $exists  = $this->validateStudy($study['medical_offices_id'], $study['studies_id']);

                 if(!$exists){

                    $studyMedicalOffice = $this->StudiesMedicalOffices->newEntity();

                    $studyMedicalOffice = $this->StudiesMedicalOffices->patchEntity($studyMedicalOffice, $study);

                    if(!$this->StudiesMedicalOffices->save($studyMedicalOffice)){

                        $success = false;

                        $errors = $studyMedicalOffice->errors();

                        break;

                    }else{


                  } 
                  
                 }

             }


            $this->set(compact('success'));

    }


    /**
     * Funcion que obtiene los servicios de un consultorio
     */
    public function getMedicalOfficesServices(){

        $data = $this->request->data;

        $medicalOfficeId  = $data['medicalOfficeId'];      

        $services = $this->StudiesMedicalOffices->find('all', 
        
                ['contain'      => ['Studies'], 
        
                 'conditions'   => [
        
                    'StudiesMedicalOffices.medical_offices_id' => $medicalOfficeId
        
                 ]
        
                ])->toArray();
        
         if ($services) {
        
            $success = true;

            $this->set(compact('success','services'));
       
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
        
    }


    /**
     * Funcion que obtiene los servicios de una especialidad por consultorio
     */
    public function getMedicalOfficesServicesBySpecialization(){

        $data = $this->request->data;

        $medicalOfficeId  = $data['medicalOfficeId'];

        $idSpecialization = $data['specializationId'];

        $services = $this->StudiesMedicalOffices->find('all',  
                             [
                                'contain' => ['Studies'], 
                                'conditions'=> [
                                    'StudiesMedicalOffices.medical_offices_id' => $medicalOfficeId,
                                    'Studies.specializations_id' => $idSpecialization
                                ]
                             ])->toArray();

        if($services) {
        
            $success = true;
            $this->set(compact('success','services'));
       
        }else{
        
            $success = false;
            $this->set(compact('success'));

        }
        
    }


    /**
     * Especializaciones relacionadas al consultorio por sus servicios
     * @return [type] [description]
     */
    public function getMedicalOfficesSpecializations(){

        // $this->autoRender = false;

        // $medicalOfficeId  = 7;
    

        $data = $this->request->data;

        $medicalOfficeId  = $data['medicalOfficeId'];

        $this->loadModel('Specializations');

        $specializations = $this->Specializations->find('all',[
                'contain'       =>  ['Studies'], 
                'conditions'    =>  ['Specializations.id in(SELECT s.specializations_id FROM studies s WHERE s.id in (SELECT smo.studies_id FROM studies_medical_offices smo WHERE smo.medical_offices_id = '.$medicalOfficeId.')) ']
            ])->toArray();

        $success = true;    

        $this->set(compact('success','specializations'));

    }

    /**
     * funcion que valida si un consultorio ya tiene asignado un estudio
     * @param  [type] $idSpecialist [description]
     * @param  [type] $idStudy      [description]
     * @return [type]               [description]
     */
    public function validateStudy($medicalOfficeId,$idStudy){
               
        $studyBySpecialist = $this->StudiesMedicalOffices->find('all',  
                [
                    'contain' => ['Studies'], 

                    'conditions'=> [
                    
                    'StudiesMedicalOffices.medical_offices_id' => $medicalOfficeId,
                    
                    'StudiesMedicalOffices.studies_id' => $idStudy
                ]

            ])->toArray();


            return $studyBySpecialist;
    } 


}
