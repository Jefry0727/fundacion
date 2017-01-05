<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Datasource\ConnectionManager;

/**
 * Appointments Controller
 *
 * @property \App\Model\Table\AppointmentsTable $Appointments
 */
class AppointmentsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['ver','getAllAppoinments','getConfrimAppoinmentsByDay','getUnconfAppointmentsDay','getAttentionAppoinmentsByDay','getAppointmentWithoutInvoice', 'getMedicalOfficesByService', 'attentions']);
    }


    public function attentions(){

    $connection = ConnectionManager::get('default');

    $data = $this->request->data;

    $myAttentios = $connection->execute("SELECT appointments.id, appointments.created, appointments.modified,
        appointments.medical_offices_id, appointments.studies_value,appointments.studies_id, appointments.type,
        appointments.observations, appointments.expected_date,
        attentions.id as attentionID, attentions.date_time_ini as fechaAtencionI,
        attentions.date_time_end as fechaAtencionF, attentions.users_id,
        attentions.appointments_id as appoimentId,  attentions.lend_plates
        FROM appointments
        INNER JOIN(attentions)
        ON appointments.id = attentions.appointments_id
        WHERE appointments.id = 2703 ;")->fetchAll('assoc');

    if($myAttentios){

        $success = true;

        $this->set(compact('success', 'myAttentios'));
    }else{

        $success = false;

        $errors = $myAttentios->errors();

        $this->set(compact('success', 'errors'));

    }

        

    }

    /**
     * Consulta que retorna los consultorio con base en el codigo del estudio
     * @return [type] [description]
     */
    public function ver(){

        $this->loadModel('ScheduleIntervals');
        $this->loadModel('ScheduleSpecialists');
        $this->autoRender = false;

        // Consulta que obtiene los consultorios segun el estudio de consulta
        
        /*$arreglo = $this->StudiesMedicalOffices->find('all',
            [
                'contain' => ['Studies'],
                'conditions' => ['Studies.id' => 1] // Estudio de consulta - Reemplazar
            ] 
        )
        ->select(['Studies.id', 'Studies.name', 'Studies.specializations_id', 'medical_offices_id'])
        ->toArray();*/

        // Consulta que obtiene la ultima fecha de asignación mas reciente para un consultorio
        /*$arreglo = $this->ScheduleIntervals->find('all',
            [
                'contain' => ['MedicalOffices'],
                'conditions' => ['MedicalOffices.id' => 7], // Consultorio - Reemplazar
                'order' => ['ScheduleIntervals.date_end' => 'DESC'],
                'limit' => 1,
            ] 
        )
        //->select(['Studies.id', 'Studies.name', 'Studies.specializations_id', 'medical_offices_id'])
        ->toArray();*/
        
        // Consulta que permite conocer la agenda del especialista por dia
        $arreglo = $this->ScheduleSpecialists->find('all',
            [
            'contain' => ['Specialists'],
                'conditions' => ['ScheduleSpecialists.day' => 1] // Dia de 0 a 6 (Lunes a Domingo) - Reemplazar
                ] 
                )
        //->select(['Studies.id', 'Studies.name', 'Studies.specializations_id', 'medical_offices_id'])
        ->toArray();


        pr($arreglo);

    }


    /**
     * Consulta que retorna los consultorios con base en el codigo del estudio
     * @return [type] [description]
     */
    
    public function getMedicalOfficesByService(){

    
        $data =  $this->request->data;

        $studyId = $data['studyId'];


        $this->loadModel('StudiesMedicalOffices');
        
        // Consulta que obtiene los consultorios segun el estudio de consulta
        $medicaOffices = $this->StudiesMedicalOffices->find('all',[

            'contain'       => ['Studies','MedicalOffices'],
            'group'=>"MedicalOffices.id",
            
                'conditions'    => ['Studies.id IN' => $studyId ] // Estudio de consulta - Reemplazar

                ])->select(['MedicalOffices.id','MedicalOffices.code','MedicalOffices.name'])->toArray();

        if($medicaOffices){
            $this->set(compact('medicaOffices'));
        }else{
            $success = false;
            $this->set(compact('success'));
        }
        
        
    }

    /**
     * Consulta que obtiene la ultima fecha de asignación mas reciente para un consultorio
     * @return [type] [description]
     */
    public function getAvailableDatesRangeByMedicalOffice(){

        $this->loadModel('ScheduleIntervals');

        $medicalOfficeId = $this->request->data['medicalOfficeId'];

        $scheduleInterval = $this->ScheduleIntervals->find('all',[
            'contain' => ['MedicalOffices'],
            'conditions' => ['MedicalOffices.id' => $medicalOfficeId],
            'order' => ['ScheduleIntervals.date_end' => 'DESC'],
            'limit' => 1,
            ] 
            )->first();


        if($scheduleInterval){

            $dateIni = Date('Y-m-d');

            $dateEnd = $scheduleInterval['date_end']->i18nFormat('yyyy-MM-dd');

            $success = true;

            $this->set(compact('success', 'dateIni', 'dateEnd'));

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
        $this->paginate = [
        'contain' => ['MedicalOffices', 'Orders', 'Studies']
        ];
        $appointments = $this->paginate($this->Appointments);

        $this->set(compact('appointments'));
        $this->set('_serialize', ['appointments']);
    }

    /**
     * View method
     *
     * @param string|null $id Appointment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $appointment = $this->Appointments->get($id, [
            'contain' => ['MedicalOffices', 'Orders', 'Studies']
            ]);

        $this->set('appointment', $appointment);
        $this->set('_serialize', ['appointment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $appointment = $this->Appointments->newEntity();
        if ($this->request->is('post')) {
            $appointment = $this->Appointments->patchEntity($appointment, $this->request->data);
            if ($this->Appointments->save($appointment)) {
                $this->Flash->success(__('The appointment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The appointment could not be saved. Please, try again.'));
            }
        }
        $medicalOffices = $this->Appointments->MedicalOffices->find('list', ['limit' => 200]);
        $orders = $this->Appointments->Orders->find('list', ['limit' => 200]);
        $studies = $this->Appointments->Studies->find('list', ['limit' => 200]);
        $this->set(compact('appointment', 'medicalOffices', 'orders', 'studies'));
        $this->set('_serialize', ['appointment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Appointment id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $appointment = $this->Appointments->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appointment = $this->Appointments->patchEntity($appointment, $this->request->data);
            if ($this->Appointments->save($appointment)) {
                $this->Flash->success(__('The appointment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The appointment could not be saved. Please, try again.'));
            }
        }
        $medicalOffices = $this->Appointments->MedicalOffices->find('list', ['limit' => 200]);
        $orders = $this->Appointments->Orders->find('list', ['limit' => 200]);
        $studies = $this->Appointments->Studies->find('list', ['limit' => 200]);
        $this->set(compact('appointment', 'medicalOffices', 'orders', 'studies'));
        $this->set('_serialize', ['appointment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Appointment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $appointment = $this->Appointments->get($id);
        if ($this->Appointments->delete($appointment)) {
            $this->Flash->success(__('The appointment has been deleted.'));
        } else {
            $this->Flash->error(__('The appointment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    /**
     * Funcion que guarda una nueva cita
     * @return [type] [description]
     */
    public function saveAppointment(){


        $data = $this->request->data;

        $data['consents'] = 0; // no se ha firmado un consentimiento 

        $data['expected_date'] = substr( $data['expected_date'], 0, 10 );

        $appointment = $this->Appointments->newEntity();

        $appointment = $this->Appointments->patchEntity($appointment, $data);

        if ($this->Appointments->save($appointment)) {


           $success = true;

           $this->set(compact('success','appointment'));


           } else {

            $success = false;

            $errors = $appointment->errors();

            $this->set(compact('success','errors'));

        }
    }

    /**
     * Función para actualizar una cita
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-12
     * @datetime 2016-09-12T16:15:54-0500
     * @return   [type]                   [description]
     */
    public function updateAppointment(){

        $data = $this->request->data;

        $id = $data['id'];

        $appointment = $this->Appointments->get($id, ['contain' => []]);
        
        $appointment = $this->Appointments->patchEntity($appointment, $data);
    
        if ($this->Appointments->save($appointment)) {
    
            $success = true;
            $this->set(compact('success'));
        } else {
            $success = false;
            $this->set(compact('success'));
         

        }


    }


    /**
     * Funcion para buscar una cita por su id
     * @return [type] [description]
     */
    public function getAppointment(){


        $id = $this->request->data['id'];

        $appointment = $this->Appointments->get($id, [
            'contain'       => ['AppointmentDates'] 
            ]);


        $success = true;

        $this->set(compact('success','appointment'));



    }

    /**
     * Funcion que elimina una cita
     * @return [type] [description]
     */
    public function deleteAppointment(){

        $id = $this->request->data['id'];

        $appointment = $this->Appointments->get($id);

        if ($this->Appointments->delete($appointment)) {

            $success = true;

            $this->set(compact('success'));

        } else {

            $success = false;

            $this->set(compact('success'));

        }

    }

/**
 * [getAllAppoinments description]
 * @return [type] [description]
 */
public function getAllAppoinments( $idOrder = null ){


    //  $this->autoRender = false;

    // $idOrder = 29;
    if(empty($idOrder)){
        $data = $this->request->data;

        $idOrder = $data['id'];
    }
    

    $this->loadModel('Orders');

    $appointments = $this->Appointments->find('all',
        ['contain' => ['Studies','Studies.Specializations','Studies.Instructives','Studies.Services','MedicalOffices']
     
        ]);

    $appointments = $appointments->matching('Orders', function ($q) use ($idOrder) {
        return $q->where(['Orders.id' =>$idOrder ]);
    }); 

    // obtiene el utlimo cambio registrado en la cita y la filtra por asignada o reasignada.
    $appointments = $appointments->matching('AppointmentDates', function ($q) {
        return $q->where([
            'AppointmentDates.id = (SELECT MAX(ad.id) FROM appointment_dates ad WHERE ad.appointments_id = Appointments.id)'        
        ]);

    })->matching('AppointmentDates.AppointmentStates', function ($q) {
        return $q->where([
            'AppointmentDates.appointment_states_id = AppointmentStates.id'        
        ]);

    })->toArray();




    // pr();


    /**
     * url de instructivos
     */
    $url = Router::url('/'.'resources/', true).'instructives/';


    foreach ($appointments as $appointment) {
      

        $appointment['_matchingData']['AppointmentDates']['date_time_ini'] = $appointment['_matchingData']['AppointmentDates']['date_time_ini']->i18nFormat('YYYY-MM-dd hh:mm:ss a');
         

        $appointment['_matchingData']['AppointmentDates']['date_time_end'] = $appointment['_matchingData']['AppointmentDates']['date_time_end']->i18nFormat('YYYY-MM-dd hh:mm:ss a');     
   



        if(count($appointment['study']['instructives']) > 0){


            foreach ($appointment['study']['instructives'] as $instructive) {
               
                $instructive['url'] =  $url.$instructive['url'];                

            }
        
        }

    

    }

    


    if($appointments){
        

        $appointments = json_decode(json_encode($appointments), true);


        $rates_id = $appointments[0]['_matchingData']['Orders']['rates_id'];


        

        // Obtener el costo y los datos de los productos asociados
        for($i = 0; $i < count($appointments); $i++){
        
            if( !empty( $appointments[$i]['study']['services'] ) ){

                foreach($appointments[$i]['study']['services'] as $llave => $valor){
                    
                    foreach($valor as $llave2 => $valor2){

                        if($llave2 == 'id'){
                            $services_id[] = $valor2;
                        }

                    }
                
                }
            
            }


        }


        if(!empty($services_id)){
            $conection = ConnectionManager::get('default');
            for($i = 0; $i < count($services_id); $i++){
                
                

                $res=$conection->execute(
                    'SELECT rate_services.value,rate_services.value as cost,services.cup 
                     FROM rate_services INNER JOIN services ON rate_services.servicises_id = services.id
                     WHERE rate_services.rates_id = ' . $rates_id . ' AND rate_services.state = 1 AND services.id=' . $services_id[$i]
                )->fetchAll('assoc');
                if(!empty($res)){
                    $services_details[] = $res[0];
                }
            }
        }

        // Ya se obtubo el costo   
      

        //Poner los costos en en arreglo que se enviara
        for($i = 0; $i < count($appointments); $i++ ){

            $appointments[$i]['study']['products'] = $appointments[$i]['study']['services'];
            unset($appointments[$i]['study']['services']);

            if( !empty( $services_details ) ){


                for( $b = 0; $b < count($services_details); $b++ ){
                    
                    if( !empty( $appointments[$i]['study']['products'][$b] ) && !empty( $services_details[$b] )){
                        $appointments[$i]['study']['products'][$b] = array_merge($appointments[$i]['study']['products'][$b],$services_details[$b]);
                    }  
            
                }

            }
            
        
        }
        // Ya se pusieron los costos y dema datos que faltaban






            
        $this->set(compact('appointments','success'));
        
    } else {

        $success = false;

        $this->set(compact('success','errors'));

    }
}


/**
 * Obtiene las citas confirmadas pero que no han sido atendidas.
 * @return [type] [description]
 */
public function getConfrimAppoinmentsByDay(){

    // $this->autoRender = false;

    // $date = '2016-09-22';
    // $idCenter = 1;
    // $idSpeciality = 0; 

    $data = $this->request->data;
    $date = $data['date'];
    
    $dateEnd = $data['dateEnd'];

    $idCenter = $data['center'];
    $idSpeciality = $data['speciality'];

    $this->loadModel('Specializations');

    if($idSpeciality != 0){
            $specializations = $this->Specializations->find('all',
                        ['conditions'=>['Specializations.cost_centers_id' => $idSpeciality]]
                    )->select(['Specializations.id']);

    }else{

           $specializations = $this->Specializations->find('all')->select(['Specializations.id']);
    }



    $this->loadModel('Attentions');
    $this->loadModel('Orders');    

    $query = $this->Appointments->find('all')->notMatching('Attentions', function ($q) {
     return $q->where([
      'Appointments.id not in ' => 'Attentions.appointments_id'
      ]);
     });

    //para que se busque en todos los centros el id del centro debe ser igual a all ·
    if($idCenter != "all"){
      $query = $query->matching('Orders', function ($q) use ($idCenter) {
        return $q->where(['Orders.centers_id' =>$idCenter ]);
      });  
    }else{
        $query = $query->matching('Orders', function ($q) use ($idCenter) {
        return $q->where(['Orders.centers_id >' =>0 ]);
      }); 
    }
    //fin de busqueda
    
  
    $query = $query->find('all',
        ['contain' => [
            'Studies',
            'Orders.Patients.People',
            'MedicalOffices'],
        'conditions'=> ['Studies.specializations_id IN' => $specializations

        ]

        ]);  

             // obtiene las citas que se encuetren confirmadas.
    $query = $query->matching('AppointmentDates', function ($q) use ( $date, $dateEnd) {

        return $q->where([

            'DATE(AppointmentDates.date_time_ini) >='     => $date,

            'DATE(AppointmentDates.date_time_ini) <='     => $dateEnd,


            'AppointmentDates.appointment_states_id '   => 3,

            'AppointmentDates.id = (SELECT MAX(ad.id) FROM appointment_dates ad WHERE ad.appointments_id = Appointments.id)'

            ]);
    });


    $query = $query->toArray();

    if($query){
     
        
        $this->set(compact('query','success'));

    } else {

        $success = false;

        $this->set(compact('success','errors'));

    }
}




/**
 * carga todos las citas para el dia actual, que estan agendadas o reagendadas.  // pero no han sido confirmadas
 *
 * @return [type] [description]
 */
public function getUnconfAppointmentsDay(){

    // $this->autoRender = false;
    // $date = '2016-10-06';
    // $idCenter = 2;
    // $idSpeciality = 0;

    $data = $this->request->data;
    $date = $data['date'];
    $dateEnd = $data['dateEnd'];
    $idCenter = $data['center'];
    $idSpeciality = $data['speciality'];

    $this->loadModel('Specializations');
        
    if($idSpeciality != 0){
        
            $specializations = $this->Specializations->find('all',
                        ['conditions'=>['Specializations.cost_centers_id' => $idSpeciality]]
                    )->select(['Specializations.id']);

    }else{
           $specializations = $this->Specializations->find('all')->select(['Specializations.id']);
    }
  
    $this->loadModel('Orders');


    $query = $this->Appointments->find('all',
        ['contain' => [
            'Studies',
            'Orders.Patients.People',
            'MedicalOffices']
        ,'conditions'=> [
                'Studies.specializations_id IN' => $specializations]
     ]);


    // obtiene el utlimo cambio registrado en la cita y la filtra por asignada o reasignada.
    $query = $query->matching('AppointmentDates', function ($q) use ( $date, $dateEnd) {

        return $q->where([

            'DATE(AppointmentDates.date_time_ini) >='     => $date,
            'DATE(AppointmentDates.date_time_ini) <='     => $dateEnd, 

            'AppointmentDates.appointment_states_id IN '   => [1,2], // agendado y reagendado.

            'AppointmentDates.id = (SELECT MAX(ad.id) FROM appointment_dates ad WHERE ad.appointments_id = Appointments.id)'        
                    ]);

    });


        //para que se busque en todos los centros el id del centro debe ser igual a all ·
        if($idCenter != "all"){
            $query = $query->matching('Orders', function ($q) use ($idCenter) {
                return $q->where(['Orders.centers_id' =>$idCenter ]);
            });  
        }else{
            $query = $query->matching('Orders', function ($q) use ($idCenter) {
                return $q->where(['Orders.centers_id >' =>0 ]);
            }); 
        }
        //fin de busqueda



    if($query){
        $query = $query->toArray();
        
        $this->set(compact('query','success'));

    } else {

        $success = false;

        $this->set(compact('success','errors'));

    }
    //debug($query);
}
   

    /**
     * funcion que obtiene las citas que ya tienen una atencion.
     * @return [type] [description]
     */
    public function getAttentionAppoinmentsByDay(){

        // $this->autoRender = false;
    
        // $date = '2016-08-30';
        // $idCenter = 1;
        // $idSpeciality = 1; 
    

        $data = $this->request->data;
        $date = $data['date'];
        $dateEnd = $data['dateEnd'];
        $idCenter = $data['center'];
        $idSpeciality = $data['speciality'];   

        $this->loadModel('Attentions');
        $this->loadModel('Orders');
        $this->loadModel('Specializations');

        if($idSpeciality == 0){

        
        $query = $this->Appointments->find('all',
            ['contain' => [
                 'Studies',
                 'Orders.Patients.People',
                 'MedicalOffices'],
            'conditions'=> [
            // 'Studies.specializations_id IN' => $specializations,
           // 'Studies.specializations_id IN (SELECT sp.id FROM specializations sp WHERE sp.cost_centers_id ='.$idSpeciality.')',
            'Appointments.id = (SELECT at.appointments_id FROM attentions at WHERE at.appointments_id = Appointments.id GROUP BY at.appointments_id )'
            
            ]]);

        }else{
        
              
        $query = $this->Appointments->find('all',
           ['contain' => [
                 'Studies',
                 'Orders.Patients.People',
                 'MedicalOffices'],
            'conditions'=> [
            // 'Studies.specializations_id IN' => $specializations,
            'Studies.specializations_id IN (SELECT sp.id FROM specializations sp WHERE sp.cost_centers_id ='.$idSpeciality.')',
            'Appointments.id = (SELECT at.appointments_id FROM attentions at WHERE at.appointments_id = Appointments.id GROUP BY at.appointments_id ) '
             ]]);
        }


          
        //para que se busque en todos los centros el id del centro debe ser igual a all ·
        if($idCenter != "all"){
            $query = $query->matching('Orders', function ($q) use ($idCenter) {
                return $q->where(['Orders.centers_id' =>$idCenter ]);
            });  
        }else{
            $query = $query->matching('Orders', function ($q) use ($idCenter) {
                return $q->where(['Orders.centers_id >' =>0 ]);
            }); 
        }
        //fin de busqueda
        

  
        $query = $query->matching('AppointmentDates', function ($q) use ( $date, $dateEnd ) {

          return $q->where([

            'DATE(AppointmentDates.date_time_ini) >='     => $date,

            'DATE(AppointmentDates.date_time_ini) <='     => $dateEnd, 

            'AppointmentDates.appointment_states_id '   => 3,

            'AppointmentDates.id = (SELECT MAX(ad.id) FROM appointment_dates ad WHERE ad.appointments_id = Appointments.id )',

            ]);
      });
   



        if($query){
            $query = $query->toArray();
            
            $this->set(compact('query','success'));

        } else {

            $success = false;

            $this->set(compact('success','errors'));

        }
    }


    /*
      Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
      Fecha: 2016-11-23 08:02:12
      Tipo de retorno:  void
      Descripción: Esta funcion envia a la vista la lista de appoinments que tiene un usuario, consultados a travez de su numero de identificacion
    */
    public function getAppointmentsByIdentification(){


        $identificacion = $this->request->data[ 'identification' ];
        $page = $this->request->data[ 'offset' ];
        $resultadoConsulta = $this->Appointments->find('all',[
            'contain'=>[  
                'Studies',
                'MedicalOffices'
             ]
            ]
        );

        $resultadoConsulta->matching('Orders.Patients.People',
            function( $q ) use ( $identificacion)  {
                return $q->where( [ 'People.identification' => $identificacion ]);
            }
        )
        ->matching('AppointmentDates',
            function( $q ){
                // trae el ultimo registro en appointment_dates
                return $q->select(['date_time_ini'])
                         ->where(["AppointmentDates.id = (SELECT MAX(ad.id) FROM appointment_dates ad WHERE ad.appointments_id = Appointments.id)"]);

            }

        )->matching(
            'AppointmentDates.AppointmentStates',
            function( $q ){
                return $q->select(['state']);
            }
        )->order(['date_time_ini'=>'DESC'])
        ->limit(15)
        ->page( $page );

        if( $resultadoConsulta ){
          
            $success = true;
            $appointments =  $resultadoConsulta;
            $this->set( compact( 'success', 'appointments' ) );
        
        }
        else{

            $success = false;
            if( $resultadoConsulta->errors() ){

                $appointments = $resultadoConsulta->errors();

            }
            else{
                
                $appointments = [];

            }
              $this->set( compact( 'success', 'appointments' ) );

        }


       

    }


}







