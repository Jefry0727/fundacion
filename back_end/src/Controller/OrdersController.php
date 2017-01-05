<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Para Usar la clase ConnectionManager
 * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
 * 2016-09-12 08:02:48
 */
use Cake\Datasource\ConnectionManager;


/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController
{



    public function initialize(){

        parent::initialize();

        $this->Auth->allow(['ver',
        
                'getWithoutPayment',
        
                'getNewOrderNumber',
        
                'getWithoutResult',

                'getLendPlatesResult',
        
                'getByAppointment',
        
                'getWhitResult',
        
                'getExternalSpecialist',
        
                'getWithPayment',

                'getPhotoPeople'
            
                ]
        );


        $this->loadComponent('ResourceManager');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index(){
        $this->paginate = [
            'contain' => ['OrderDetails', 'Users', 'OrderStates']
        ];
        $orders = $this->paginate($this->Orders);

        $this->set(compact('orders'));
        $this->set('_serialize', ['orders']);
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['OrderDetails', 'Users', 'OrderStates']
        ]);

        $this->set('order', $order);
        $this->set('_serialize', ['order']);
    }




    /**
     * Obtiene toda la informacion de una orden.
     */
    public function getOrderById(){


        $data = $this->request->data;

         $id = $data['id'];

        $order = $this->Orders->find('all', 
            [
                'contain' => [
                    'Patients.People',
                    'ExternalSpecialists',
                    'Centers',
                    'CieTenCodes'
                ],
                'conditions'=>[
                    'Orders.id' => $id
                ]   
            ])->first();

        if($order){

                $success = true;

                $this->set(compact('success','order'));

        }else{
            $success = false;

            $this->set(compact('success'));

        }

    }



    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addOrder()
    {
        $order_consec = $this->Orders->newEntity();

        $data = $this->request->data;

        
        $id = $this->request->data['name'];

        $data['order_details_id']= 12;
        $data['users_id'] = 1;
        $data['order_states_id'] = 1;
         if(empty($data['bill_types_id'])){
                $data['bill_types_id'] = 1;
            }

        $order_consec = $this->Orders->patchEntity($order_consec, $data);

        if ($this->Orders->save($order_consec)) {
               
            $success = true;

           $this->set(compact('success', 'order_consec'));


        } else {
        
           $success = false;

           $errors = $order_consec->errors();

           $this->set(compact('success', 'errors'));

        }
         
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editOrder($id = null)
    {
        $order_consec = $this->Orders->get($id, [
            'contain' => []
        ]);

            $order_consec = $this->Orders->patchEntity($order_consec, $this->request->data);



            if ($this->Orders->save($order_consec)) {

                $success = true;

                $this->set(compact('success', 'order_consec'));

            } else {
                $success = false;

                $this->set(compact('success'));
            }
        
       
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteOrder($id = null)
    {
       $order_consec = $this->request->data['id'];

       if( $this->Orders->delete($order_consec))
       {

        $success= true;

        $this->set(compact('success', 'order_consec'));

       }else{
        $success = false;

        $this->set(compact('success'));
       }
    }

    /**
     * Get method
     *
     * @param string|null $id Order id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    
   public function getOrderConsec(){



        $data = $this->request->data;
        
        
        $offset = $data['offset'];

        $order_consec = $this->Orders->find('all', ['limit' => 10,'offset'=> $offset]);

        $orderTotal = $this->Orders->find('all')->count();
        
        if ($order_consec) {
        
            $success = true;

            $this->set(compact('success','order_consec','orderTotal'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }


    }

    public function getNewOrderNumber($id = 1){

        $lenghConsect = 4;


        $this->loadModel('Centers');

        $actualDate = DATE('Ymd');

        /**
         * Numero de orden
         * @var integer
         */
        $newOrderNumber = 0;


        /**
         * sede
         * @var [type]
         */
        $center = $this->Centers->get($id);


        /**
         * Codigo de la sede
         * @var [type]
         */
        $centerCode = $center['code'];

        /**
         * Ultima orden de la sede consultada
         * @var Array
         */
        $lastOrder = $this->Orders->find('all',['limit'=>1, 'order' => 'Orders.id DESC', 'conditions'=>['Orders.centers_id'=>$id]])->first();
    
        /**
         * Si hay ninguna orden para esa sede
         */
        if($lastOrder){


            /**
             * ultimo numero de orden
             * @var [type]
             */
            $lastOrderNumber =  $lastOrder['order_consec'];


            /**
             * Fecha de la ultima orden
             * @var String
             */
            $orderDate = substr($lastOrderNumber, 0, -6);
            
            /**
             * Si la fecha actual es diferente a la de la ultima orden de la sede
             */
            if($actualDate != $orderDate){

                $newOrderNumber = $this->newOrderNumer($actualDate,$centerCode,0);



            }else{
                /**
                 * Si la fecha actual y la fecha de la ultima orden son iguales
                 */

                /**
                 * Ultimo numero de orden 
                 * @var String
                 */
                $lastNumber = substr($lastOrderNumber,  ($lenghConsect * -1) );

                /**
                 * Ultimo numero de orden
                 * @var Int
                 */
                $intLastNumber = intval($lastNumber);


                $newOrderNumber = $this->newOrderNumer($actualDate,$centerCode, $intLastNumber);
            
            }



        }else{

            /**
             * Si no hay ninguna orden para esa sede
             */

            $newOrderNumber = $this->newOrderNumer($actualDate,$centerCode,0);



        }


        return $newOrderNumber;


    }

    /**
     * New Order number
     * @param  [type] $date            [description]
     * @param  [type] $centerCode      [description]
     * @param  [type] $lastOrderNumber [description]
     * @return [type]                  [description]
     */
    public function newOrderNumer($date, $centerCode, $lastOrderNumber){

            $newNumber = $lastOrderNumber + 1;

            $lenghConsect = 4;

            $newNumberLength = strlen($newNumber);

            $longZeros = $lenghConsect - $newNumberLength;

            $prefixZeros = '';

            for ($i = 0; $i < $longZeros; $i++) { 
                    
                $prefixZeros = $prefixZeros .'0';    

            }

            

            return $date.$centerCode.$prefixZeros.$newNumber;


    }


    /**
     * Julián Andrés Muñoz Cardozo
     * 2016-08-09 08:20:53
     * Función que crea o edita una nueva orden
     */
    public function saveOrder(){


            $order = $this->Orders->newEntity();

            $newData = $this->request->data;

            $newData['order_states_id'] = 1;

            $newData['consultation_endings_id'] = 1;

            $newData['external_causes_id'] = 1;

            if(empty($newData['bill_types_id'])){
                $newData['bill_types_id'] = 1;
            }
            /**
             * Usuario que guarda la orden
             */
            $newData['users_id'] = $this->Auth->user('id');

            /**
             * Eliminacion de indices innecesarios para que no se dupliquen al guardar/editar
             */
            
            
            unset($newData['cie_ten_code']);

            unset($newData['bills']);

            unset($newData['patient']);

            unset($newData['center']);

            unset($newData['external_specialist']);




            /**
             * Julián Andrés Muñoz Cardozo
             * 2016-08-09 08:05:32
             * Si existe un identificador de orden la editamos
             */
            if(!empty($newData['id']) && ($newData['id'] !=='' && $newData['id'] !== 0 )){


                /**
                 * Edicion de orden si esta existe
                 */

                $order = $this->Orders->get($newData['id']);
                            
                $order = $this->Orders->patchEntity($order, $newData);

                if ($this->Orders->save($order)) {
                
                    $success = true;

                    // $this->Orders->find('all',['contain'=>['']]);

                    $this->set(compact('success','order'));
           
            
                } else {

                    $success = false;
          
                    $errors = $order->errors();

                    $this->set(compact('success','errors'));
                    
                }

            }else{  
                /**
                 * Julián Andrés Muñoz Cardozo
                 * 2016-08-09 08:05:07
                 * agregado de la orden
                 */

                $order = $this->Orders->patchEntity($order, $newData);

                $order->order_consec = $this->getNewOrderNumber($newData['centers_id']);

                if ($this->Orders->save($order)) {
                
                    $success = true;

                    // $this->Orders->find('all',['contain'=>['']]);

                    $this->set(compact('success','order'));
           
            
                } else {

                    $success = false;

                    $errors = $order->errors();

                    $this->set(compact('success','errors'));
                    
            }
        }
    }


    public function getNumberAppointmentOrder(){

        $this->loadModel('OrderAppointments');

        $success = true;

        $order_id = $this->request->data['orderId'];

        $total = $this->OrderAppointments->find('all',['conditions'=>['OrderAppointments.orders_id'=> $order_id]])->count();

        $this->set(compact('success','total'));

    }

    /**
     * Guardado de nueva relacion de detalle de orden con una cita
     */
    public function saveOrderAppointment(){

        $this->loadModel('OrderAppointments');

        $success = true;

        $data = $this->request->data;

        $orderDetailId = $data['order_details_id'];
        
        $appointmenIds = $data['appointments_ids'];

        foreach ($appointmenIds as $appointmentId) {
            
            $orderAppointment = $this->OrderAppointments->newEntity();

            $orderAppointment = $this->OrderAppointments->patchEntity($orderAppointment, Array('orders_id'=>$orderDetailId,'appointments_id'=>$appointmentId));

            if (!$this->OrderAppointments->save($orderAppointment)) {

                    $success = false;

            }
                
        }

        $total = $this->OrderAppointments->find('all',['conditions'=>['OrderAppointments.orders_id'=> $orderDetailId]])->count();

        $this->set(compact('success','total'));

    }

    /**
     * Obtener las ordenes que no tienen un pago..
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-10-07
     * @datetime 2016-10-07T12:24:52-0500
     * @return   [type]                   [description]
     */
    public function getWithoutPayment(){

    $data = $this->request->data;

    $idCenter = $data['center'];
    $dateIni = $data['dateIni'];
    $dateEnd = $data['dateEnd'];
    
    $this->loadModel('Appointments');

   // $this->loadModel('Bills');

    //para que se busque en todos los centros
    if($idCenter=="all"){
        $idCenter=0;
        $condicion = "Orders.centers_id >";
    }
    else{
        $condicion = "Orders.centers_id";
    }
    //end
    
    $query = $this->Orders->find('all', 
            ['contain' => [
                'Patients.People',
                'Appointments.Studies',
                'Appointments.AppointmentDates.AppointmentStates',
                'Centers'
                ],
            'conditions'=>[
                $condicion => $idCenter,
                'DATE(Orders.created) >=' => $dateIni,
                'DATE(Orders.created) <=' => $dateEnd,
                //que no tienen una factura
                'Orders.id NOT IN (SELECT b.orders_id FROM orders_bills b WHERE b.orders_id = Orders.id)'
            ]   
            ]);



    if ($query) {

         $query = $query->toArray();
        
            $success = true;

            $this->set(compact('success','query'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }

    }

    /**
     * Get the Orders Whit Payments
     * @return [type] [description]
     */
    public function getWithPayment(){

    // $this->autoRender = false;

    // $idCenter = 2;
    // $dateIni = '2016-07-01';
    // $dateEnd = '2016-10-30';

    $data = $this->request->data;

    $idCenter = $data['center'];
    $dateIni = $data['dateIni'];
    $dateEnd = $data['dateEnd'];
    
    $this->loadModel('Appointments');
    $this->loadModel('Bills');


    //para que se busque en todos los centros
    if($idCenter=="all"){
        $idCenter=0;
        $condicion = "Orders.centers_id >";
    }
    else{
        $condicion = "Orders.centers_id";
    }
    //end

    $query = $this->Orders->find('all', 
            ['contain' => [
                'Patients.People',
                'Appointments.Studies',
                'Appointments.AppointmentDates.AppointmentStates',
                'Centers'
                ],
            'conditions'=>[
                $condicion => $idCenter,
                'DATE(Orders.created) >=' => $dateIni,
                'DATE(Orders.created) <=' => $dateEnd,
                'Orders.id IN (SELECT b.orders_id FROM orders_bills b WHERE b.orders_id = Orders.id)'
            ]   
            ]);

    if ($query) {

         $query = $query->toArray();
        
            $success = true;

            $this->set(compact('success','query'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }

    }





    /**
     * Obtiene Ordenes sin resultados.
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-09-12
     * @datetime 2016-09-12T16:22:10-0500
     * @return   [type]                   [description]
     */
    public function getWithoutResult(){

     // $this->autoRender = false;

     // $idCenter = 1;
     //  $dateIni = '2016-07-01';
     // $dateEnd = '2016-09-01';

    $data = $this->request->data;

    $idCenter = $data['center'];
    $dateIni = $data['dateIni'].' 00:00:00';
    $dateEnd = $data['dateEnd'].' 23:59:59';
    $cost_centers = $data['cost_centers'];

   // $idSpecialization = $data['idSpecialization'];
    

    $this->loadModel('Appointments');

        $conn = ConnectionManager::get('default');

        //Obtiene resultados sin prestamo de placas
        $query = $conn->execute("
            SELECT orders.id as order_id, 
                   appointments.id as appointment_id, 
                   orders.centers_id as center,
                   attentions.created  as fecha
            FROM orders 
            LEFT JOIN order_appointments on  orders.id = order_appointments.orders_id
            LEFT JOIN appointments on order_appointments.appointments_id = appointments.id 
            LEFT JOIN attentions on attentions.appointments_id = appointments.id
            LEFT JOIN results on results.attentions_id = attentions.id
            LEFT JOIN studies on studies.id = appointments.studies_id
            join specializations on specializations.id = studies.specializations_id
            join cost_centers on cost_centers.id = specializations.cost_centers_id
            WHERE attentions.id IS NOT NULL
             AND  attentions.lend_plates = 0
             AND  results.id IS NULL 
             AND  DATE(attentions.created) BETWEEN '".$dateIni."' AND '".$dateEnd."' 
             AND  orders.centers_id = ".$idCenter."
             AND  cost_centers.id = ".$cost_centers)->fetchAll('assoc'); 

         $idAppointment= [];

         $orderIds = [];

         // pr($query);


        foreach ($query as $row) {

                $idAppointment[] = $row['appointment_id']; 
       
                $orderIds[] = $row['order_id'];
        }

        $orderIds = array_unique($orderIds);

        $result = [];

        $index = 0;                
        foreach ($orderIds as $orderId) {
    
            $result[$index]['order'] = $this->Orders->find('all',[
                'contain'=>[
                    'Patients.People', 
                    'Appointments.Studies',
                    'Appointments.AppointmentDates.AppointmentStates',
                    'ExternalSpecialists',
                    'Centers',
                    'Clients'
                ],
                'conditions' => [
                    'Orders.id' => $orderId

                    ]])->first();

            $result[$index]['appointments'] =  $this->Appointments->find('all',[
                    'contain'=>['Studies','MedicalOffices','Attentions'],
                    'conditions' => [
                        'Appointments.id IN'=>$idAppointment,
                        'Appointments.id  IN (SELECT oa.appointments_id FROM order_appointments oa WHERE oa.orders_id ='.$orderId.' )'
                    ]
           
            ])->toArray();

            $index = $index + 1;
        }     
         //pr($result);

    if ($result) {
        
            $success = true;

            $this->set(compact('success','result'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }

    }

    /**
     * Obtiene los estudios que tienen placas prestadas.
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-09-12
     * @datetime 2016-09-12T16:22:10-0500
     * @return   [type]                   [description]
     */
    public function getLendPlatesResult(){

     // $this->autoRender = false;

     // $idCenter = 1;
     //  $dateIni = '2016-07-01';
     // $dateEnd = '2016-09-01';

    $data = $this->request->data;

    $idCenter = $data['center'];
    $dateIni = $data['dateIni'].' 00:00:00';
    $dateEnd = $data['dateEnd'].' 23:59:59';
    

    $this->loadModel('Appointments');

        $conn = ConnectionManager::get('default');

        //Obtiene resultados sin prestamo de placas
        $query = $conn->execute("
            SELECT orders.id as order_id, 
                   appointments.id as appointment_id, 
                   orders.centers_id as center,
                   attentions.created  as fecha
            from orders 
            left join order_appointments on  orders.id = order_appointments.orders_id
            left join appointments on order_appointments.appointments_id = appointments.id 
            left join attentions on attentions.appointments_id = appointments.id
            left join results on results.attentions_id = attentions.id
            where attentions.id is not null
             and  attentions.lend_plates = 1
             and  results.id is null
             and  DATE(attentions.created) BETWEEN '".$dateIni."' AND '".$dateEnd."' 
             and  orders.centers_id = ".$idCenter)->fetchAll('assoc'); 

         $idAppointment= [];

         $orderIds = [];

         // pr($query);


        foreach ($query as $row) {

                $idAppointment[] = $row['appointment_id']; 
       
                $orderIds[] = $row['order_id'];
        }

        $orderIds = array_unique($orderIds);

        $result = [];

        $index = 0;                
        foreach ($orderIds as $orderId) {
    
            $result[$index]['order'] = $this->Orders->find('all',[
                'contain'=>[
                    'Patients.People', 
                    'Appointments.Studies',
                    'Appointments.AppointmentDates.AppointmentStates',
                    'ExternalSpecialists',
                    'Centers',
                    'Clients'
                ],
                'conditions' => [
                    'Orders.id' => $orderId

                    ]])->first();

            $result[$index]['appointments'] =  $this->Appointments->find('all',[
                    'contain'=>['Studies','MedicalOffices','Attentions'],
                    'conditions' => [
                        'Appointments.id IN'=>$idAppointment,
                        'Appointments.id  IN (SELECT oa.appointments_id FROM order_appointments oa WHERE oa.orders_id ='.$orderId.' )'
                    ]
           
            ])->toArray();

            $index = $index + 1;
        }     
         //pr($result);

    if ($result) {
        
            $success = true;

            $this->set(compact('success','result'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }

    }

    /**
     * Obtiene Ordenes que tienen un Resultado.
     * @return [type] [description]
     */
    public function getWhitResult(){

     // $this->autoRender = false;

     // $idCenter = 1;
     // $dateIni = '2016-07-01';
     // $dateEnd = '2016-07-30';

    $data = $this->request->data;

    $idCenter = $data['center'];
    $dateIni = $data['dateIni'];
    $dateEnd = $data['dateEnd'];
    $cost_centers = $data['cost_centers'];
    $state = $data['state'];
    $complement = $data['complement'];

    if($state == 0 && $complement == 1){

        $state = 'BETWEEN 0 and 2';

    }else{

        $state = ' = '.$state;

    }

    $this->loadModel('Appointments');
    $this->loadModel('Results');

        $conn = ConnectionManager::get('default');


        $query = $conn->execute("SELECT orders.id as order_id, 
                   appointments.id as appointment_id, 
                   orders.centers_id as center,
                   attentions.created  as fecha
            from orders
            left join order_appointments on  orders.id = order_appointments.orders_id
            left join appointments on order_appointments.appointments_id = appointments.id 
            left join attentions on attentions.appointments_id = appointments.id
            left join results on results.attentions_id = attentions.id
            LEFT JOIN studies on studies.id = appointments.studies_id
            join specializations on specializations.id = studies.specializations_id
            join cost_centers on cost_centers.id = specializations.cost_centers_id
            where attentions.id is not null 
                and  results.id is not null AND results.complement =".$complement."
                and results.id = (SELECT MAX(rs.id) FROM results rs WHERE rs.attentions_id = attentions.id)
                and  DATE(attentions.created) BETWEEN '".$dateIni."' AND '".$dateEnd."' 
                and  orders.centers_id = ".$idCenter." and cost_centers.id = ".$cost_centers." and results.state ".$state)->fetchAll('assoc'); 

          // and  orders.created > '.$dateIni.' 
          // and  orders.created < '.$dateEnd.'
          // and  DATE(Orders.created) BETWEEN '.$dateIni.' AND '.$dateEnd.'

         $idAppointment= [];

        $orderIds = [];
        foreach ($query as $row) {

                $idAppointment[] = $row['appointment_id']; 
       
                $orderIds[] = $row['order_id'];
        }

        $orderIds = array_unique($orderIds);

        $result = [];

        $index = 0;                
        foreach ($orderIds as $orderId) {
    
            $result[$index]['order'] = $this->Orders->find('all',[
                'contain'=>['Patients.People.DocumentTypes','ExternalSpecialists','Clients'],
                      'conditions' => [
                    'Orders.id' => $orderId
                  
                    ]])->first();

            $result[$index]['appointments'] =  $this->Appointments->find('all',[
                    'contain'=>['Studies','MedicalOffices','Attentions'],
                    'conditions' => [
                        'Appointments.id IN'=>$idAppointment,
                        'Appointments.id  IN (SELECT oa.appointments_id FROM order_appointments oa WHERE oa.orders_id ='.$orderId.' )'
                    ]
           
            ])->toArray();

            $index = $index + 1;
        }     
         //pr($result);

    if ($result) {
        
            $success = true;

            $this->set(compact('success','result'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }




    }

    /**
     * Obtiene una Orden de acuerdo a un apoitnment 
     * @return [type] [description]
     */
    public function getByAppointment (){

       // $this->autoRender = false;

       // $idAppointment  = 30;

       $data = $this->request->data;

        $idAppointment  = $data['id'];
        
        $this->loadModel('Appointments');

        $query = $this->Orders->find('all', 
                
              [  'contain' =>  ['Appointments.Attentions', 'Patients.People','Appointments.Studies','Appointments.MedicalOffices','ExternalSpecialists']]
            
            )->matching('Appointments', function ($q) use ($idAppointment) {
             
                   return $q->where(['Appointments.id'=> $idAppointment]);
              
                });


         if ($query) {

             $query = $query->toArray();
            
                $success = true;

                $this->set(compact('success','query'));
        
            }else{
            
                $success = false;

                $this->set(compact('success'));

            }


    }

    public function getExternalSpecialist()
    {
        

        $ExternalSpecialist = $this->Orders->find('all', ['contain'=>['ExternalSpecialists']])->toArray();

        if($ExternalSpecialist)
        {
            $success = true;

            $this->set(compact('success', 'ExternalSpecialist'));
        }else{

            $success = false;

            $this->set(compact('success'));
        }
    }


    /**
     * Obtiene los resultados de una o varias ordenes.
     * @return [type] [description]
     */
    public function ordersResults(){

         // $this->autoRender = false;
         // $id = 4;
         // $type = 1;

        $data = $this->request->data;

        $id = $data['id'];
        $type = $data['type'];

        // $query;
         // print_r($data);

        switch ($type) {
          case '1':
                
            // $query= $this->Orders->getOrderByPatient($id);

            // foreach ($query as $key => $value) {
                
            //     $result = $this->Orders->getResultByOrder($value['order_code']);

            //     $value['result'] = $result;        
            // }

              $query= $this->Orders->getResultByPatient($id);
          
              break;
              
          case '2':
               $query= $this->Orders->getResultByOrder($id);
              break;
          
          default:
              # code...
              break;
        }
       
         if ($query) {
            
                $success = true;

                $this->set(compact('success','query'));
        
            }else{
            
                $success = false;

                $this->set(compact('success', 'query'));

            }
    
    }

    public function saveFiles(){


        $order = json_decode($this->request->data['data']);

        $orderId = $order->orderId;

        /**
         * Guardar un archivo
         */
        $savedFiles = $this->ResourceManager->saveResources($orderId, 'orders', 'order_files', 'orderFiles');


        if($savedFiles !== false){

            $success = true;


            $this->set(compact('success','savedFiles'));            

        }else{


            $success = false;

            $this->set(compact('success'));            

        }

    }
    
    public function getOrderFiles(){


        $orderId = $this->request->data['orderId'];

        $savedFiles = $this->ResourceManager->getResources($orderId, 'orders', 'order_files');

        $this->set(compact('savedFiles'));            


    }


    public function dropOrderFile(){

        $resourceId =  $this->request->data['resourceId'];
        $orderId = $this->request->data['orderId'];

        $savedFiles = $this->ResourceManager->deleteResource($resourceId, $orderId, 'orders');

        $this->set(compact('savedFiles'));            

    }


    public function savePhotoPeople(){

        $data = json_decode($this->request->data['data']);

        $peopleId = $data->peopleId;


        $resource = $this->ResourceManager->getResources($peopleId, 'people', 'profile_pic');

        if($resource){

            $resource = $resource[0];

            $this->ResourceManager->deleteResource($resource['id'], $resource['entity_id'], 'people');
        }

        /**
         * Guardar un archivo
         */
        $savedFile = $this->ResourceManager->saveResource($peopleId, 'people', 'profile_pic', 'people_pictures');

        // $resourceId =  $this->request->data['resourceId'];
        // $orderId = $this->request->data['orderId'];

        $this->set(compact('peopleId','savedFile'));            

    }


    
    public function getPhotoPeople(){

        $peopleId = $this->request->data['id'];

        $picture = $this->ResourceManager->getResources($peopleId, 'people', 'profile_pic');

        if(!$picture){


            $success = false;

            $this->set(compact('success'));            

        }else{

            $picture = $picture[0];

            $success = true;

            $this->set(compact('success','picture'));            

        }

    }


    public function getOrderAuthorizations(){
        $data = $this->request->data;
        $dateIni = $data['dateIni'].' 00:00:00';
        $dateEnd = $data['dateEnd'].' 23:59:59';

        //var_dump($dateIni);
        // var_dump($dateEnd);
        $ordenes = $this->Orders->find('all',
                    [
                        'contain'=>['Rates'],
                        'conditions'=>[
                            'Orders.created >=' => $dateIni,
                            'Orders.created <=' => $dateEnd,
                            'Orders.centers_id' => $data['centerId'],
                            'Rates.require_authorization' => 1
                        ]
                    ]
                   );

   
        if(  $ordenes ){
            switch($data['authorized']){
                case "0":
                    $ordenes = $this->getAuthorized($ordenes);
                    break;
                case "1":
                    $ordenes = $this->getPending($ordenes);
                    break;
                default:
                    $ordenes = $this->getNotAuthorized($ordenes);
            }

        }

        
        if($ordenes){

            $success = true;
            $ordenes = $ordenes->fetchAll('assoc');
            $this->set( compact( 'success', 'ordenes' ) );
        
        }
        else{
        
 
            $success = false;
            $this->set( compact( 'success', 'ordenes' ) );
        
        }
    }




    // Obtiene las ordenes que ya estan autorizadas 
    // Carlos Felipe Aguirre Taborda 
    // 2016-11-15 08:13:26
    private function getAuthorized($data){
        
        $order = json_decode( json_encode($data), true );
        
        if( empty( $order ) ){

            return [];
        
        }


        $orderIds = "";

        foreach( $order as $valor ){
            
            $orderIds .= "," . $valor['id'];
        
        }

        $orderIds = "(" . substr( $orderIds , 1, strlen( $orderIds ) ) . ")";


        $conn = ConnectionManager::get('default');

        $resultado = $conn->execute(" 
                SELECT 
                    orders.id, 
                    orders.order_consec,
                    people.identification, 
                    CONCAT(people.first_name,' ',people.middle_name,' ',people.last_name,' ',people.last_name_two) as fullname,
                    rates.name,
                    orders_authorization.id as authorization_id,
                    orders_authorization.state,
                    orders_authorization.observations

                FROM orders
                LEFT JOIN orders_authorization
                    ON orders.id = orders_authorization.orders_id
                LEFT JOIN patients 
                    ON patients.id = orders.patients_id
                LEFT JOIN people
                    ON people.id = patients.people_id
                LEFT JOIN rates
                    ON rates.id = orders.rates_id
                WHERE 
                    orders_authorization.state = 1
                AND
                    orders.id IN ". $orderIds ."
            ");

        return $resultado;
    }



    // Obtiene las ordenes que requieren autotización pero aún estan pendientes
    // es decir no se han autorizado ni rechazado
    // Carlos Felipe Aguirre Taborda
    // 2016-11-15 08:16:15

    private function getPending($data){
        $order = json_decode( json_encode($data), true );
        
        if( empty( $order ) ){

            return [];
        
        }


        $orderIds = "";

        foreach( $order as $valor ){
            
            $orderIds .= "," . $valor['id'];
        
        }

        $orderIds = "(" . substr( $orderIds , 1, strlen( $orderIds ) ) . ")";
        
        $conn = ConnectionManager::get('default');

        $resultado = $conn->execute(" 
                SELECT
                    orders.id, 
                    orders.order_consec,
                    people.identification, 
                    CONCAT(people.first_name,' ',people.middle_name,' ',people.last_name,' ',people.last_name_two) as fullname,
                    rates.name
                FROM orders
                LEFT JOIN patients 
                    ON patients.id = orders.patients_id
                LEFT JOIN people
                    ON people.id = patients.people_id
                LEFT JOIN rates
                    ON rates.id = orders.rates_id
                WHERE 
                    orders.id IN ". $orderIds ."
                AND 
                    orders.id NOT IN ( SELECT orders_id FROM orders_authorization )
            ");
        

        return $resultado;

    }



    // Obtiene las ordenes que requieren autorizacion
    // pero que su autorizacion fue rechazada
    // Carlos Felipe Aguirre Taborda 2016-11-15 10:41:12

    private function getNotAuthorized($data){
            
        $order = json_decode( json_encode($data), true );
        
        if( empty( $order ) ){

            return [];
        
        }

        $orderIds = "";

        foreach( $order as $valor ){
            
            $orderIds .= "," . $valor['id'];
        
        }

        $orderIds = "(" . substr( $orderIds , 1, strlen( $orderIds ) ) . ")";


        $conn = ConnectionManager::get('default');

        $resultado = $conn->execute(" 
                SELECT 
                    orders.id, 
                    orders.order_consec,
                    people.identification, 
                    CONCAT(people.first_name,' ',people.middle_name,' ',people.last_name,' ',people.last_name_two) as fullname,
                    rates.name,
                    orders_authorization.id as authorization_id,
                    orders_authorization.state,
                    orders_authorization.observations
                FROM orders
                LEFT JOIN orders_authorization
                ON orders.id = orders_authorization.orders_id
                LEFT JOIN patients 
                    ON patients.id = orders.patients_id
                LEFT JOIN people
                    ON people.id = patients.people_id
                LEFT JOIN rates
                    ON rates.id = orders.rates_id
                WHERE 
                    orders_authorization.state = 0
                AND
                    orders.id IN ". $orderIds ."
            ");


        return $resultado;
    
    }

}






