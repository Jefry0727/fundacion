<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * ScheduleIntervals Controller
 *
 * @property \App\Model\Table\ScheduleIntervalsTable $ScheduleIntervals
 */
class ScheduleIntervalsController extends AppController
{


        
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['saveFile','saveFileSignature','get']);
    
        $this->loadComponent('LogRegister');

        $this->loadComponent('ResourceManager');
    
    }



    public function saveFile(){



        /**
         * Guardar un archivo
         */
         $this->ResourceManager->saveResource(2, 'patients', 'profile_pic', '123456');



        // pr($this->ResourceManager->getResources(1, 'profile_pic'));

        // $content = "SVG content";

        //$this->ResourceManager->saveResourceCreateFile(1, 'studies_consents', 'consent_signature', 'consent_signatures', $content, 'svg', 'signature_c1');


        

        // $this->ResourceManager->deleteResource(63, 2,'patients');

    
    }

 

    public function saveSignature(){

        $data = $this->request->data;

        $content = $data['content'];

        $appointmentsId = $data['appointments_id'];

        $signatures = $this->ResourceManager->getResources($appointmentsId, 'studies_consents', 'consent_signature');

        foreach ($signatures as $signature) {
                
            $this->ResourceManager->deleteResource($signature['id'], $signature['entity_id'], 'studies_consents');
            
        }

        $result = $this->ResourceManager->saveResourceCreateFile($appointmentsId, 'studies_consents', 'consent_signature', 'consent_signatures', $content, 'svg', 'signature_c1');

        if($result){
                
            $success = true;

            $this->set(compact('success'));

        }else{
            $success = false;

            $this->set(compact('success','result'));

        }


    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['MedicalOffices', 'Users']
        ];
        $scheduleIntervals = $this->paginate($this->ScheduleIntervals);

        $this->set(compact('scheduleIntervals'));
        $this->set('_serialize', ['scheduleIntervals']);
    }

    /**
     * View method
     *
     * @param string|null $id Schedule Interval id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $scheduleInterval = $this->ScheduleIntervals->get($id, [
            'contain' => ['MedicalOffices', 'Users']
        ]);

        $this->set('scheduleInterval', $scheduleInterval);
        $this->set('_serialize', ['scheduleInterval']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
            $scheduleInterval = $this->ScheduleIntervals->newEntity();

            $newData = $this->request->data;

            $newData['users_id'] = $this->Auth->user('id');

            $scheduleInterval = $this->ScheduleIntervals->patchEntity($scheduleInterval, $newData);
            
            if ($this->ScheduleIntervals->save($scheduleInterval)) {

                /**
                 * Adding log
                 */
                $this->LogRegister->register('users','add',$scheduleInterval);

                $success = true;
            
            } else {
                    
                $success = false;
                $errors = $scheduleInterval->errors();
            
            }
        
            $this->set(compact('success','newData','errors'));

    }

    /**
     * Edit method
     *
     * @param string|null $id Schedule Interval id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {

            $id = $this->request->data['id'];

            $scheduleInterval = $this->ScheduleIntervals->get($id, [
                'contain' => []
            ]);


            $scheduleInterval = $this->ScheduleIntervals->patchEntity($scheduleInterval, $this->request->data);

            if ($this->ScheduleIntervals->save($scheduleInterval)) {

                $success = true;
        
            } else {

                $success = false;
            
            }

            $this->set(compact('success','scheduleInterval'));
    
    }

    /**
     * Delete method
     *
     * @param string|null $id Schedule Interval id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
        

        $id = $this->request->data['id'];

        $scheduleInterval = $this->ScheduleIntervals->get($id);

        if ($this->ScheduleIntervals->delete($scheduleInterval)) {

            $success = true;
    
        } else {

            $success = false;
        }

        $this->set(compact('success','scheduleInterval'));



    }



    /**
     * get Data from schedule intervals
     */
    public function get(){


        $data = $this->request->data;
        
        $offset = $data['offset'];

        $medicalOfficeId = $data['medicalOfficeId'];


        /**
         * Query schedule intervals by medicalOfficeId
         * @var Array
         */
        $scheduleIntervals = $this->ScheduleIntervals->find('all', [
            
            'limit'     => 10,
            'offset'    => $offset ,

            /**
             * Ordered by end date
             */
            'order'     => 'ScheduleIntervals.date_end DESC',
            /**
             * Condition of medicalOfficeId
             */
            'conditions'=> ['ScheduleIntervals.medical_offices_id'=>$medicalOfficeId]]
        
        )->toArray();


        $total = $this->ScheduleIntervals->find('all')->count();
            
        $resultsScheduleIntervals = Array();




        foreach ($scheduleIntervals as $llave => $scheduleInterval) {
           
            if( !empty( $scheduleInterval->date_ini ) ){
                $scheduleInterval->date_ini = $scheduleInterval->date_ini->i18nFormat('yyyy-MM-dd');
            }
            if( !empty( $scheduleInterval->date_end ) ){
                $scheduleInterval->date_end = $scheduleInterval->date_end->i18nFormat('yyyy-MM-dd');
            }
            // Time::setJsonEncodeFormat('yyyy-MM-dd HH:mm:ss');
        }



        if ($scheduleIntervals) {
        
            $success = true;

            $this->set(compact('success','scheduleIntervals','total','id'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }


    }
}
