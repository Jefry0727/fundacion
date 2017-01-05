<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

require_once(ROOT . DS . 'src' . DS . 'Controller' . DS . 'OrderAppointmentsController.php');

/**
 * Attentions Controller
 *
 * @property \App\Model\Table\AttentionsTable $Attentions
 */
class AttentionsController extends AppController
{


    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['attendedAppointments','appointmentForAttention','asignedAppointments','printSticker', 'getAttentionsByAppointmentId']);
        $this->loadComponent('ResourceManager');
    }


    /**
     * esta funcion actualiza es estado de prestamo
     * de una placa
     * @author Carlos Felipe Aguirre Taborda <carlosfelipeaguirre96@gmail.com>
     * @date     2016-09-13
     * @datetime 2016-09-13T11:58:30-0500
     * @return [type]                   [description]
     */
    public function updateLendPlateState(){
        $attentions_id = $this->request->data['attentions_id'];
        $attention = $this->Attentions->get($attentions_id);
        $this->Attentions->patchEntity($attention, ["lend_plates"=>0]);
        $this->Attentions->save($attention);


        $lendplates = TableRegistry::get('LendPlates');
        $lendplates->
            query()->
            update()->
            set(['return_date'=>date('Y-m-d H:i:s')])->
            where(['attentions_id'=>$attentions_id])->
            execute();
            $success = true;
        $this->set(compact('success'));
    }

    /**
     * Ind
     *  method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Appointments']
        ];
        $attentions = $this->paginate($this->Attentions);

        $this->set(compact('attentions'));
        $this->set('_serialize', ['attentions']);
    }

    /**
     * View method
     *
     * @param string|null $id Attention id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $attention = $this->Attentions->get($id, [
            'contain' => ['Users', 'Appointments']
        ]);

        $this->set('attention', $attention);
        $this->set('_serialize', ['attention']);
    }


    /**
     * Metodo para imprimir los stickers de la atenciones 
     * Carlos Felipe Aguirre Taborda
     * 29-sep-2016
    */
    
    public function printSticker(){
        $OrderAppointmentsController = new OrderAppointmentsController();
        $storedFileName=$OrderAppointmentsController->printSticker($this->request->data);  
        if(empty($storedFileName['errors'])){
            $success = true;
            $this->set(compact('success', 'storedFileName'));
        }
        else{
            $success = false;
            $errors = $storedFileName['errors'];
            $this->set(compact('success', 'errors'));

        }
    }


    public function getAttentionsByAppointmentId(){
        $id = $this->request->data['id'];
        $attention = $this->Attentions->find('all', [
            'conditions'=>['Attentions.appointments_id'=>$id]
        ]);

        if($attention){
            $attention = $attention->toArray();
            $success = true;
            $this->set(compact('success', 'attention'));
        }
        else{
            $success = false;
            $errors = $attention->errors();
            $this->set(compact('success', 'errors'));
        }
    }




    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $attention = $this->Attentions->newEntity();
        if ($this->request->is('post')) {
            $attention = $this->Attentions->patchEntity($attention, $this->request->data);
            if ($this->Attentions->save($attention)) {
                $this->Flash->success(__('The attention has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The attention could not be saved. Please, try again.'));
            }
        }
        $users = $this->Attentions->Users->find('list', ['limit' => 200]);
        $appointments = $this->Attentions->Appointments->find('list', ['limit' => 200]);
        $this->set(compact('attention', 'users', 'appointments'));
        $this->set('_serialize', ['attention']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Attention id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $attention = $this->Attentions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attention = $this->Attentions->patchEntity($attention, $this->request->data);
            if ($this->Attentions->save($attention)) {
                $this->Flash->success(__('The attention has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The attention could not be saved. Please, try again.'));
            }
        }
        $users = $this->Attentions->Users->find('list', ['limit' => 200]);
        $appointments = $this->Attentions->Appointments->find('list', ['limit' => 200]);
        $this->set(compact('attention', 'users', 'appointments'));
        $this->set('_serialize', ['attention']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Attention id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attention = $this->Attentions->get($id);
        if ($this->Attentions->delete($attention)) {
            $this->Flash->success(__('The attention has been deleted.'));
        } else {
            $this->Flash->error(__('The attention could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Adicionar registro de atencion.
     */
        public function addAttention(){

            $data = $this->request->data;
           
            $data['users_id'] = $this->Auth->user('id');

            // if(empty( $data['users_id'] )){

            //      $data['users_id']  = 1;

            // }
            
            $data['lend_plates']  = 0;

            $exist = $this->Attentions->find('all',
                ['conditions'=>['Attentions.appointments_id'=>$data['appointments_id']]])->count();
            if($exist==0){
            $attention = $this->Attentions->newEntity();

            $attention = $this->Attentions->patchEntity($attention,$data);
            
            if ($this->Attentions->save($attention)) {

                  $success = true;

                  $this->set(compact('success','attention'));

              } else {

                $success = false;

                $errors = $attention->errors();

                $this->set(compact('success','errors'));

            }

        }else{

            $attention = $this->Attentions->find('all',
                ['conditions'=>['Attentions.appointments_id'=>$data['appointments_id']]])->first();
            if($attention){
                 $success = true;

                  $this->set(compact('success','attention'));

            }else{

               
                $success = false;

                $errors = $attention->errors();

                $this->set(compact('success','errors'));
            }


        }

    }
     /**
      * Editar una atencion para adicionar fecha finalizacion.
      * @return [type] [description]
      */
     public function editAttention(){

        $id = $this->request->data['id'];

        $attention = $this->Attentions->get($id, ['contain' => []]);

            $attention = $this->Attentions->patchEntity($attention, $this->request->data);     

            if ($this->Attentions->save($attention)) {

                $success = true;

                $this->set(compact('success', 'attention'));

            } else {
               
                $success = false;

                $errors = $attention->errors();

                $this->set(compact('success','errors'));
            }
        
     }


        /**
      * Editar una atencion para  para añadir un prestamo de placas
      * @return [type] [description]
      */
     public function editAttentionLend(){


        if( !empty( $this->request->data['attentions_id'] ) ){
            $id = $this->request->data['attentions_id'];
        }
        else{
           $id = $this->request->data['id']; 
        }

        $attention = $this->Attentions->get($id, ['contain' => []]);

        $attention_update['id']= $id;
        $attention_update['lend_plates'] = 1;

            $attention = $this->Attentions->patchEntity($attention, $attention_update);     

            if ($this->Attentions->save($attention)) {

                $success = true;

                $this->set(compact('success', 'attention'));

            } else {
               
                $success = false;

                $errors = $attention->errors();

                $this->set(compact('success','errors'));
            }
        
     }


    /**
     * Citas asignadas
     */
    public function asignedAppointments(){

        $data = $this->request->data;

        $medicalOfficeId = $data['id'];

        $offset = $data['offset'];

        $this->loadModel('Appointments');

        $appointments = $this->Appointments->find('all',[

                'limit' => 10,

                'offset'=> $offset,

                'contain' => ['Orders.Patients.People.DocumentTypes','Studies','AppointmentDates'],
        
                'conditions'=>['Appointments.medical_offices_id' => $medicalOfficeId],

                'order' => ['AppointmentDates.date_time_ini' => 'ASC']
            
            ]

        // obtiene el utlimo cambio registrado en la cita y la filtra por asignada o reasignada.        
        )->matching('AppointmentDates', function ($q) {

            return $q->where([

                'DATE(AppointmentDates.date_time_ini) '     => Date('Y-m-d'), 

                'AppointmentDates.appointment_states_id IN '   => [1,2], // agendado y reagendado.

                'AppointmentDates.id = (SELECT MAX(ad.id) FROM appointment_dates ad WHERE ad.appointments_id = Appointments.id)'
                    
                        ]);

        });
          $appointments = $appointments->matching('Orders' ,function ($q) {

            return $q->where(['Orders.centers_id IS NOT NULL']);

        })->toArray();


        $total = $this->Appointments->find('all',[

                'contain' => ['Orders.Patients.People'],
        
                'conditions'=>['Appointments.medical_offices_id' => $medicalOfficeId]
            
            ]

        // obtiene el utlimo cambio registrado en la cita y la filtra por asignada o reasignada.        
        )->matching('AppointmentDates', function ($q) {

            return $q->where([


                'DATE(AppointmentDates.date_time_ini) '     => Date('Y-m-d'), 

                'AppointmentDates.appointment_states_id IN '   => [1,2], // agendado y reagendado.

                'AppointmentDates.id = (SELECT MAX(ad.id) FROM appointment_dates ad WHERE ad.appointments_id = Appointments.id)'        
                        ]);

        });


    $total = $total->matching('Orders', function ($q) {

            return $q->where(['Orders.centers_id IS NOT NULL']);

    })->count();

    
    $this->set(compact('appointments','total'));

    }


    /**
     * Citas para atencion
     */
    public function appointmentForAttention(){

        $data = $this->request->data;

        $medicalOfficeId = $data['id'];

        $offset = $data['offset'];

        $this->loadModel('Appointments');

        $appointments = $this->Appointments->find('all',[

                'limit' => 10,

                'offset'=> $offset,

                'contain' => ['Orders.Patients.People.DocumentTypes','Studies','AppointmentDates'],
        
                'conditions' => ['Appointments.medical_offices_id' => $medicalOfficeId ],

                'order' => ['AppointmentDates.date_time_ini' => 'DESC']
            
            ]

        // obtiene el utlimo cambio registrado en la cita y la filtra por asignada o reasignada.        
        )->matching('AppointmentDates', function ($q) {

            return $q->where([


                'DATE(AppointmentDates.date_time_ini) '     => Date('Y-m-d'), 

                'AppointmentDates.appointment_states_id IN '   => [3], //confirmado

                'AppointmentDates.id = (SELECT MAX(ad.id) FROM appointment_dates ad WHERE ad.appointments_id = Appointments.id)'        
                        ]);

        })->notMatching('Attentions', function ($q) {
               
               return $q->where([ 'Appointments.id NOT IN' => 'Attentions.appointments_id'
                    ]);

        });

          $appointments = $appointments->matching('Orders', function ($q) {

            return $q->where(['Orders.centers_id IS NOT NULL']);

        })->toArray();

        $total = $this->Appointments->find('all',[

                'contain' => ['Orders.Patients.People'],
        
                'conditions' => ['Appointments.medical_offices_id' => $medicalOfficeId ]
            
            ]

        // obtiene el utlimo cambio registrado en la cita y la filtra por asignada o reasignada.        
        )->matching('AppointmentDates', function ($q) {

            return $q->where([


                'DATE(AppointmentDates.date_time_ini) '     => Date('Y-m-d'), 

                'AppointmentDates.appointment_states_id IN '   => [3], //confirmado

                'AppointmentDates.id = (SELECT MAX(ad.id) FROM appointment_dates ad WHERE ad.appointments_id = Appointments.id)'        
                        ]);

        })->notMatching('Attentions', function ($q) {
               
               return $q->where([ 'Appointments.id NOT IN' => 'Attentions.appointments_id'
                    ]);

        });


     $total = $total->matching('Orders', function ($q) {

            return $q->where(['Orders.centers_id IS NOT NULL']);

        })->count();

        $this->set(compact('appointments','total'));


    }

    /**
     * Citas atendidas
     */
    public function attendedAppointments(){

        $data = $this->request->data;

        $medicalOfficeId = $data['id'];

        $offset = $data['offset'];

        $this->loadModel('Appointments');

        $appointments = $this->Appointments->find('all',[

                'contain' => ['Orders.Patients.People.DocumentTypes','Studies','AppointmentDates','Attentions'],

                'conditions' => [

                    'Appointments.medical_offices_id' => $medicalOfficeId, 

                    'Appointments.id IN (SELECT a.appointments_id FROM attentions a WHERE a.appointments_id =  Appointments.id)'

                ],

                'order' => ['Attentions.date_time_ini' => 'ASC'],

                'limit' => 20,

                'offset'=> $offset

                
            
            ]

        // obtiene el utlimo cambio registrado en la cita y la filtra por asignada o reasignada.        
        )->matching('AppointmentDates', function ($q) {

            return $q->where([


                'DATE(AppointmentDates.date_time_ini) '     => Date('Y-m-d'), 

                'AppointmentDates.appointment_states_id '   => 3, //confirmado

                'AppointmentDates.id = (SELECT MAX(ad.id) FROM appointment_dates ad WHERE ad.appointments_id = Appointments.id)'

                        ]);
            //se hace el join con attentions para ordenar por fecha.
        })->matching('Attentions', function ($q) {

            return $q;

        });

        $appointments = $appointments->matching('Orders', function ($q) {

            return $q->where(['Orders.centers_id IS NOT NULL']);

        })->toArray();


        // pr($appointments);

        $total = $this->Appointments->find('all',[

        
                'conditions' => [

                    'Appointments.medical_offices_id' => $medicalOfficeId, 

                    'Appointments.id IN (SELECT a.appointments_id FROM attentions a WHERE a.appointments_id =  Appointments.id)',

               
                ]

            
            ]

        // obtiene el utlimo cambio registrado en la cita y la filtra por asignada o reasignada.        
        )->matching('AppointmentDates', function ($q) {

            return $q->where([


                'DATE(AppointmentDates.date_time_ini) '     => Date('Y-m-d'), 

                'AppointmentDates.appointment_states_id '   => 3, //confirmado

                'AppointmentDates.id = (SELECT MAX(ad.id) FROM appointment_dates ad WHERE ad.appointments_id = Appointments.id)'        
                        ]);

        });


    $total = $total->matching('Orders', function ($q) {

            return $q->where(['Orders.centers_id IS NOT NULL']);

        })->count();


        $this->set(compact('appointments','total'));

    }


}
