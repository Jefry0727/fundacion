<?php
namespace App\Controller;

use App\Controller\AppController;


/**
 * PhpExcel
 */
require_once(ROOT . DS . 'vendor' . DS . "PHPExcel" . DS . "Classes" . DS . "PHPExcel.php");

/**
 * Para Usar la clase ConnectionManager
 * Deicy Rojas H.
 */
use Cake\Datasource\ConnectionManager;


// use App\Controller\PHPExcel;

class ResolutionsController extends AppController {


  public function initialize()
  {
    parent::initialize();
    $this->Auth->allow(['resolution4505']);
  }

  public function resolution4505(){

          // $this->autoRender = false;

     // $idCenter = 1;
     //  $dateIni = '2016-07-01';
     // $dateEnd = '2016-09-01';

    $data = $this->request->data;

     $idClient = $data['client'];
    // $dateIni = $data['dateIni'];
    // $dateEnd = $data['dateEnd'];


    $conn = ConnectionManager::get('default');




        //Obtiene resultados sin prestamo de placas
    $query = $conn->execute('SELECT
     attentions.id as attention_id,
     attentions.date_time_ini as attention_date,
     appointments.id as appointments_id,
     studies.cup as study_cups,
     studies.id as study_id,
     orders.id as order_id,
     orders.order_consec as order_code,
     orders.calculated_age as order_age,
     orders.clients_id as order_client,
     orders.patients_id as patient_id,
     results.id as result_id,
     results.created as result_date,
     people.id, 
     people.document_types_id, 
     people.identification, 
     people.first_name, 
     people.middle_name, 
     people.last_name, 
     people.last_name_two, 
     people.birthdate, 
     people.gender
     FROM attentions
     left join appointments on appointments.id = attentions.appointments_id
     left join studies on studies.id = appointments.studies_id
     left join order_appointments on order_appointments.appointments_id =  appointments.id
     left join orders on orders.id = order_appointments.orders_id
     left join patients on   orders.patients_id = patients.id
     left join people on people.id = patients.people_id
     left join results on results.attentions_id = attentions.id
     where 
     (studies.cup = '."'876802'".' or
     studies.cup = '."'881201'".' or 
     studies.cup = '."'702201'".'or
     studies.cup = '."'851102'".') and 
     attentions.id is not null and 
     orders.clients_id = '.$idClient)->fetchAll('assoc');

    if($query){
     $success = true;

     $this->set(compact('success','query'));  
   }else{

     $success = false;
   }
 }



}     

