<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Patients Controller
 *
 * @property \App\Model\Table\PatientsTable $Patients
 */
class PatientsController extends AppController
{   


    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add','edit','index','delete','addPatients','searchPatients','getPatientById','searchPatientByName', 'estudiar','getallEstudiantes','getFirstEstudiante']);
    }

    /**
     * Index method
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'People']
        ];
        $patients = $this->paginate($this->Patients);

        $this->set(compact('patients'));
        $this->set('_serialize', ['patients']);
    }

    /**
     * View method
     */
    public function view($id = null)
    {
        $patient = $this->Patients->get($id, [
            'contain' => ['Users', 'People']
        ]);

        $this->set('patient', $patient);
        $this->set('_serialize', ['patient']);
    }

    /**
     * Add method
    */
    public function add(){
        $patient = $this->Patients->newEntity();

        if ($this->request->is('post')) {

            $patient = $this->Patients->patchEntity($patient, $this->request->data);

            if ($this->Patients->save($patient)) {

               $success = true;

               $this->set(compact('success','patient'));
                            
            
            } else {    

                $success = false;

                $errors = $patient->errors();

                $this->set(compact('success','errors'));
            }
        }
    }

    /**
     * Add method
     */
    public function addPatients()
    {
        $patient = $this->Patients->newEntity();

        if ($this->request->is('post')) {

            $patient = $this->Patients->patchEntity($patient, $this->request->data);

            if ($this->Patients->save($patient)) {

               $success = true;

               $this->set(compact('success','patient'));
                            
            
            } else {    

                $success = false;

                $errors = $patient->errors();

                $this->set(compact('success','errors'));
            }
        }
    }


    /**
     * [edit description]
     * Edit the patient
     * @author Jefry Jhonatan Londoño
     * @date     2016-11-29
     * @datetime 2016-11-29T14:45:23-0500
     * 
     */
    public function editPatients()
    {
        $id= $this->request->data['id'];

        $patient = $this->Patients->get($id, [
            'contain' => []

        ]);

        $patient ['users_id']= $this->Auth->user('id');
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $patient = $this->Patients->patchEntity($patient, $this->request->data);
            if ($this->Patients->save($patient)) {
                $success = true;
            
                $this->set(compact('success','patient'));
            } 
            else 
            {

                $success = false;
                $errors = $patient->errors();
                $this->set(compact('success','errors'));
            }
        }
       
    }

    /**
     * Delete method
     *
     * @param string|null $id Patient id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $patient = $this->Patients->get($id);
        if ($this->Patients->delete($patient)) {
            $this->Flash->success(__('The patient has been deleted.'));
        } else {
            $this->Flash->error(__('The patient could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

   

    //Buscar paciente por numero de documento.
    public function searchPatients()
    {

        $this->loadModel('People');

        $id = $this->request->data['id'];
        //$people = $this->People->find('all',['conditions'=>['People.identification' => $id]]);
        //$patient = $this->People->find('all',['contain'=>['Patients'], 'conditions'=>['People.identification' => $id]]);


        $people = $this->People->find('all',['contain'=>['Patients', 'Users'], 'conditions'=>['People.identification' => $id]])->first();

        // use ($username) mandar parametros para realizar el join.
        // $people = $people->matching('Patients', function ($q) {
        //     return $q->where(['Patients.people_id = People.id' ]);
        // })->first();

        if($people){
    
            $people->birthdate = $people->birthdate->i18nFormat('YYYY-MM-dd');

            $people->phone = $people->phone;

            $people->identification = (int)$people->identification;


            $success = true;

        }else{

            $success = false;

        }

        /**
         * Sending the result
         */
        $this->set(compact('success','people'));

    }

    public function getPatientById(){

        $id = $this->request->data['id'];

        $patient = $this->Patients->find('all',
            ['contain'=>['People'],
            'conditions'=>['Patients.id'=>$id]])->first();

            if ($patient) {

               $success = true;

               $this->set(compact('success','patient'));
                            
            
            } else {    

                $success = false;

                $errors = $patient->errors();

                $this->set(compact('success','errors'));
            }
        }



    public function getallPatients(){

        $data = $this->request->data;

        $offset = $data['offset'];

        $patient = $this->Patients->find('all',

        [

        'contain'=>['People'],
         'limit' => 10, 'offset' => $offset 
        
        ]);

        $total = $this->Patients->find('all')->count();

            if ($patient) {

               $success = true;

               $this->set(compact('success','patient','total'));
                            
            
            } else {    

                $success = false;

                $errors = $patient->errors();

                $this->set(compact('success','errors'));
            }
    }

    // Buscar paciente por Nombres y apellidos.
    public function searchPatientByName($term)
    {        
        $this->autoRender = false;

        $this->loadModel('People');

        $people = $this->People->find('all', 
            ['conditions'=>["CONCAT(People.first_name,People.middle_name,People.last_name,People.last_name_two)like '%".$term."%'"]]);
        

        // use ($username) mandar parametros para realizar el join.
        $people = $people->matching('Patients', function ($q) {
            return $q->where(['Patients.people_id = People.id' ]);
        })->toArray();
    
        // foreach ($people as $person) {
        
        //         $person = unset($person['_matchingData']);

        // }        

        echo json_encode(Array('servicesDiagnostic'=>$people));

        // $this->set(compact('services'));
    }



    public function getAll(){

        $patients = $this->patients->find('all',['contains'=>['People']])->toArray();
        $this->set(compact('success','patient'));

    }


    
}
