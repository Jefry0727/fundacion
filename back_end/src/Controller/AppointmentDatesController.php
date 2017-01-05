<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Datasource\ConnectionManager;

/**
 * AppointmentDates Controller
 *
 * @property \App\Model\Table\AppointmentDatesTable $AppointmentDates
 */
class AppointmentDatesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['cancelAppointment','confirmationAppointment', 'getAvaibilityCalendar']);
    }


     /**
      * [getAvaibilityCalendar description]
      * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
      * @date     2016-11-09
      * @datetime 2016-11-09T15:57:15-0500
      * @return   [type]                   [Obtiene las citas del consultorio en especifico]
      */
     public function getAvaibilityCalendar(){


        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $fechaI = $data['dateS'];

        $fechaF = $data['dateE'];

        $idMedicalO = $data['idMedical'];

        $idCenter = $data['idCenter'];

        $avaibilityCalendar = $connection->execute("SELECT DISTINCT
                    orders.order_consec,
                    appointment_dates.appointments_id,
                    appointment_dates.id,
                    appointment_dates.created,
                    appointment_dates.modified,
                    appointment_dates.users_id,
                    DATE_FORMAT(appointment_dates.date_time_ini,
                            '%H:%i:%s %X-%m-%d') AS fecha,
                    DATE_FORMAT(appointment_dates.date_time_end,
                            '%H:%i:%s %X-%m-%d') AS date_time_end,
                    appointment_dates.appointment_states_id,
                    appointments.id,
                    appointments.medical_offices_id,
                    appointments.studies_id,
                    appointments.type,
                    medical_offices.id,
                    medical_offices.code,
                    medical_offices.name,
                    medical_offices.description,
                    studies.id,
                    studies.cup,
                    studies.name AS nameStudy,
                    studies.specializations_id,
                    appointment_states.state,
                    people.first_name,
                    people.middle_name,
                    people.last_name,
                    people.last_name_two,
                    people.identification,
                    orders.id AS orderId
                FROM
                    appointment_dates
                        INNER JOIN
                    (appointments, medical_offices, studies, appointment_states, order_appointments, orders, patients, people) ON (appointment_dates.id = (SELECT 
                            MAX(ad.id)
                        FROM
                            appointment_dates ad
                        WHERE
                            ad.appointments_id = appointments.id)
                        AND appointment_dates.appointment_states_id = appointment_states.id
                        AND appointments.medical_offices_id = medical_offices.id
                        AND appointments.studies_id = studies.id
                        AND appointments.id = order_appointments.appointments_id
                        AND order_appointments.orders_id = orders.id
                        AND orders.patients_id = patients.id
                        AND patients.people_id = people.id)
                WHERE
                    medical_offices.id = '$idMedicalO'
                        AND medical_offices.centers_id = '$idCenter'
                        AND DATE(appointment_dates.date_time_ini) BETWEEN '$fechaI' AND '$fechaF'
                ORDER BY appointment_dates.date_time_ini ASC");


        if($avaibilityCalendar){

            $success = true;

            $avaibilityCalendar = $avaibilityCalendar->fetchAll('assoc');


           // for($i=0; $i< count( $avaibilityCalendar ); $i++ ){
              
           //    for($b=0; $b < count( $avaibilityCalendar ); $b++){
                


           //      if( empty( $avaibilityCalendar[$i ]) || empty( $avaibilityCalendar[$b ] ) || $i = $b){
           //        continue;
           //      }

           //      if($avaibilityCalendar[$i]['appointments_id'] == $avaibilityCalendar[$b]['appointments_id']){
                  
           //        unset($avaibilityCalendar[$b]);
                
           //      }
              
           //    }

           // }

            $this->set(compact('success', 'avaibilityCalendar'));

        }else{

            $success = false;

            $errors = $getAvaibilityCalendar->errors();

            $this->set(compact('success','errors'));
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
        'contain' => ['Appointments', 'Users', 'AppointmentStates']
        ];
        $appointmentDates = $this->paginate($this->AppointmentDates);

        $this->set(compact('appointmentDates'));
        $this->set('_serialize', ['appointmentDates']);
    }

    /**
     * View method
     *
     * @param string|null $id Appointment Date id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $appointmentDate = $this->AppointmentDates->get($id, [
            'contain' => ['Appointments', 'Users', 'AppointmentStates']
            ]);

        $this->set('appointmentDate', $appointmentDate);
        $this->set('_serialize', ['appointmentDate']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $appointmentDate = $this->AppointmentDates->newEntity();
        if ($this->request->is('post')) {
            $appointmentDate = $this->AppointmentDates->patchEntity($appointmentDate, $this->request->data);
            if ($this->AppointmentDates->save($appointmentDate)) {
                $this->Flash->success(__('The appointment date has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The appointment date could not be saved. Please, try again.'));
            }
        }
        $appointments = $this->AppointmentDates->Appointments->find('list', ['limit' => 200]);
        $users = $this->AppointmentDates->Users->find('list', ['limit' => 200]);
        $appointmentStates = $this->AppointmentDates->AppointmentStates->find('list', ['limit' => 200]);
        $this->set(compact('appointmentDate', 'appointments', 'users', 'appointmentStates'));
        $this->set('_serialize', ['appointmentDate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Appointment Date id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $appointmentDate = $this->AppointmentDates->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appointmentDate = $this->AppointmentDates->patchEntity($appointmentDate, $this->request->data);
            if ($this->AppointmentDates->save($appointmentDate)) {
                $this->Flash->success(__('The appointment date has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The appointment date could not be saved. Please, try again.'));
            }
        }
        $appointments = $this->AppointmentDates->Appointments->find('list', ['limit' => 200]);
        $users = $this->AppointmentDates->Users->find('list', ['limit' => 200]);
        $appointmentStates = $this->AppointmentDates->AppointmentStates->find('list', ['limit' => 200]);
        $this->set(compact('appointmentDate', 'appointments', 'users', 'appointmentStates'));
        $this->set('_serialize', ['appointmentDate']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Appointment Date id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $appointmentDate = $this->AppointmentDates->get($id);
        if ($this->AppointmentDates->delete($appointmentDate)) {
            $this->Flash->success(__('The appointment date has been deleted.'));
        } else {
            $this->Flash->error(__('The appointment date could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }



    /**
     * Funcion que guarda una nueva cita
     * @return [type] [description]
     */
    public function saveAppointmentDates(){

        $data = $this->request->data;

        $getAppointmentsDate = $this->AppointmentDates->find('all',[
            'conditions'=>[
                           'AppointmentDates.appointments_id' => $data['appointments_id']],
        ])->first();

        

        $appointmentDates = $this->AppointmentDates->newEntity();

        $data['users_id'] = $this->Auth->user('id');

        $appointmentDates = $this->AppointmentDates->patchEntity($appointmentDates, $data);

        if(!$getAppointmentsDate){

            if ($this->AppointmentDates->save($appointmentDates)) {

                $success = true;

                /**
                 * Para el resultado de la consulta
                 * @var [type]
                 */
                $appointmentDates->date_time_ini = $appointmentDates->date_time_ini->i18nFormat('YYYY-MM-dd hh:mm:ss a');

                $this->set(compact('success','appointmentDates'));

            } else {

                $success = false;

                $errors = $appointmentDates->errors();

                $this->set(compact('success','errors'));

            }
           
        }else{

            $success = false;

            $errors = $appointmentDates->errors();

            $message = 'Esta fecha esta agendada, por favor seleccione otra fecha';

            $this->set(compact('success','errors','message'));

        }

        // $this->set(compact('date'));
        
    }

    /**
     * Funcion que guarda una nueva cita
     * @return [type] [description]
     */
    public function cancelAppointmentDates(){

        $data = $this->request->data;

        $appointmentDates = $this->AppointmentDates->newEntity();

        $data['users_id'] = $this->Auth->user('id');

        $appointmentDates = $this->AppointmentDates->patchEntity($appointmentDates, $data);

        if($appointmentDates['appointment_states_id'] == 4){

           if ($this->AppointmentDates->save($appointmentDates)) {

                $success = true;
                
                $this->set(compact('success','appointmentDates'));

            } else {

                $success = false;

                $errors = $appointmentDates->errors();

                $this->set(compact('success','errors'));

            }

          }else{
                $success = false;

                $message = 'Se encuentra cancelada';

                $errors = $appointmentDates->errors();

                $this->set(compact('success','errors','message'));
          }
           
           

        // $this->set(compact('date'));
        
    }

    /**
     * Funcion que devuelve un objeto vacio o no 
     * @return [type] [description]
     */
    public function getValidationAppointment(){

        $data = $this->request->data;
        


        //Valida que la fecha y hora del agendamiento no sea una fecha pasada 

        // if(strtotime($data['date_time_ini']) < time()){

        //     $success = false;

        //     $message = 'No es posible agendar en la hora seleccionada, por que es anterior a la actual.';

        //     $this->set(compact('success','message'));

        // }else{ Ojo fecha anterior a la actual restriccion

            // SELECT * FROM appointment_dates WHERE '2016-07-14 22:30:00' BETWEEN date_time_ini AND date_time_end;

            $getAppointmentsDate = $this->AppointmentDates->find('all',[

                'contain'       =>  ['Appointments'],
            
                'conditions'=>[ 

                  /**
                   * Julián Andrés Muñoz Cardozo
                   * 2016-08-09 16:18:12
                   */
                  'AppointmentDates.appointment_states_id IN '   => [1,2], // agendado y reagendado.

                  /**
                   * Julián Andrés Muñoz Cardozo
                   * 2016-08-09 16:19:08
                   * Buscando entre las fechas
                   */
                  
                  // Se modificó la condición de <= a = para que permita establecer el
                  // tiempo de terminacón de una cita al mismo tiempo que termina otra
                  // Carlos Felipe Aguirre  2016-10-28 
                  "AppointmentDates.date_time_ini =   '".$data['date_time_ini']."'",

                  "AppointmentDates.date_time_end > '".$data['date_time_ini']."'",


                  // "'".$data['date_time_ini']."' BETWEEN AppointmentDates.date_time_ini AND AppointmentDates.date_time_end ",


                  /**
                   * consulta por el ultimo registro de appointmentIds
                   */
                  'AppointmentDates.id = (SELECT MAX(ad.id) FROM appointment_dates ad WHERE ad.appointments_id = Appointments.id)',

                  'Appointments.medical_offices_id' => $data['idOffice']


                ]

            ])->first();

            if(!$getAppointmentsDate){

                $success = true;

                $message = 'Esta fecha se encuentra libre de agendamiento.';

                $this->set(compact('success','message','getAppointmentsDate'));
               
            }else{

                $success = false;

                $errors = $getAppointmentsDate->errors();

                $message = 'Esta fecha esta agendada, por favor seleccione otra.';

                $this->set(compact('success','errors','message','getAppointmentsDate'));

            }

     //} Ojo fecha anterior a la actual restriccion
    }

    /**
     * Funcion que guarda una nueva cita
     * @return [type] [description]
     */
    public function getAppointmentDates(){

        $id = $this->request->data['id'];

        $appointments = $this->AppointmentDates->find('all',[
            'conditions'=>['AppointmentDates.appointments_id' => $id],
            'order' => ['AppointmentDates.appointment_states_id' => 'DESC'],
                'limit' => 1,
            ])->first();

        if($appointments['appointment_states_id'] == 1 || $appointments['appointment_states_id'] == 2){


            // pr($appointments);

            $appointments->date_time_ini = $appointments->date_time_ini->i18nFormat('YYYY-MM-dd HH:mm:ss');

            $appointments->date_time_end = $appointments->date_time_end->i18nFormat('YYYY-MM-dd HH:mm:ss');


            $data = Array(
            
                'appointments_id'       => $id,
                
                'users_id'              => $this->Auth->user('id'), 
                
                'date_time_ini'         => $appointments->date_time_ini, 
                
                'date_time_end'         => $appointments->date_time_end, 
                
                'appointment_states_id' => 3
            );
            
            $appointmentDates = $this->AppointmentDates->newEntity();

            $appointmentDates = $this->AppointmentDates->patchEntity($appointmentDates, $data);

            if ($this->AppointmentDates->save($appointmentDates)) {

                $success = true;

                $this->set(compact('success','appointmentDates'));

            } else {

                $success = false;

                $errors = $appointmentDates->errors();

                $this->set(compact('success','errors'));

            }
         }

        // $this->set(compact('appointments'));
       
    }


    /**
     * Si fecha de inicio de una cita esta entre dos fechas
     */
  // $appointments =  $this->AppointmentDates->find('all',[

  //           'conditions'=> [

  //             "AppointmentDates.date_time_ini <=   '".$eventsToUpdate['start']."'",

  //             "AppointmentDates.date_time_end > '".$eventsToUpdate['start']."'"

  //           ]

  //       ])->first();  
  //       
  //       
  //       



    
    /**
     * Julián Andrés Muñoz Cardozo
     * 2016-08-11 09:18:01
     * Funcion que cheque y actualiza si es necesario el cambio de consultorio de una cita
     */
    public function checkAppointmentChange($appointmentDateId, $medicalOfficeId){

        /**
         * Obtenemos el consultorio asignado de la cita
         */

        $appointment = $this->AppointmentDates->get($appointmentDateId);

        $appointmentMedicalOfficeId = $appointment['Appointments']['medical_offices_id'];

        $appointmentId = $appointment['appointments_id'];


        if($appointmentMedicalOfficeId != $medicalOfficeId){


            $this->loadModel('Appointments');

            $appointment = $this->Appointments->get($appointmentId);

            $appointment = $this->Appointments->patchEntity($appointment, ['medical_offices_id'=> $medicalOfficeId]);
            

            if($this->Appointments->save($appointment)){


            }

            return true;

        }else{

            return false;
        }


    }

    public function updateAppointmentDates(){

      $data = $this->request->data;

      $medicalOfficeId = $data['medicalOfficeId'];

      $eventsToUpdate = $data['eventsToUpdate'];

      $checkAppointementEdited = false;


      $editedAppointment = Array();

      for ($i=0; $i < count($eventsToUpdate); $i++) { 


        if(!empty($eventsToUpdate[$i]['checkForEdition'])){

            /**
             * Consultamos si se ha cambiado de consultorio
             * @var [type]
             */
            $checkAppointementEdited = $this->checkAppointmentChange($eventsToUpdate[$i]['id'], $medicalOfficeId);


        }

      
        $appointment =  $this->AppointmentDates->find('all',[

            'conditions'=> [

              "AppointmentDates.date_time_ini = '".$eventsToUpdate[$i]['start']."'",

              "AppointmentDates.date_time_end = '".$eventsToUpdate[$i]['end']."'",

              "AppointmentDates.id " => $eventsToUpdate[$i]['id']

            ]

        ])->first();  


        /**
         * Si no se encuentra la cita, se pondra como reasignada o si es una cita que cambio de consultorio
         */
        if(!$appointment || $checkAppointementEdited){


          $appointment =  $this->AppointmentDates->find('all',[

              'conditions'=> [

                "AppointmentDates.id " => $eventsToUpdate[$i]['id']

              ]

          ])->first();  


            $newAppointmentDate = $this->AppointmentDates->newEntity();
      

            $newAppointmentDateData = Array(
                'date_time_ini'         => $eventsToUpdate[$i]['start'], 
                'date_time_end'         => $eventsToUpdate[$i]['end'],
                'appointments_id'       => $appointment->appointments_id, 
                  
                /**
                 * Reasignado
                 */
                'appointment_states_id' => 2, 
                'users_id'              => $this->Auth->user('id')
            );


            /**
             * Guardado del nuevo registro de la cita como reasignada
             */
            $newAppointmentDate = $this->AppointmentDates->patchEntity($newAppointmentDate, $newAppointmentDateData);
            

            if ($this->AppointmentDates->save($newAppointmentDate)) {
                
                if($checkAppointementEdited == true || !empty($eventsToUpdate[$i]['checkForEdition'])){

                    /**
                     * obtencion y formateo de la cita editada
                     * @var [type]
                     */
                    
                    $newAppointmentDate->date_time_ini = $newAppointmentDate->date_time_ini->i18nFormat('YYYY-MM-dd hh:mm:ss a');

                    $newAppointmentDate->date_time_end = $newAppointmentDate->date_time_end->i18nFormat('YYYY-MM-dd hh:mm:ss a');


                    $editedAppointment = $newAppointmentDate;
                }

            }

            $checkAppointementEdited = false;
            
        }

     }



      $success = true;


      $this->set(compact('success','editedAppointment'));
    
    }

    public function saveAttention(){
    $data = $this->request->data;

     $appointmentDates = $this->AppointmentDates->newEntity();

        $data['users_id'] = $this->Auth->user('id');

        $appointmentDates = $this->AppointmentDates->patchEntity($appointmentDates, $data);

        if($appointmentDates){
                $success = true;

                $this->set(compact('success','appointmentDates'));

        } 
        else {

                $success = false;

                $errors = $appointmentDates->errors();

                $this->set(compact('success','errors'));

        }


    }

}
