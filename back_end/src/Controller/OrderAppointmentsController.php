<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OrderAppointments Controller
 *
 * @property \App\Model\Table\OrderAppointmentsTable $OrderAppointments
 */
class OrderAppointmentsController extends AppController
{   

     public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['printSticker','downloadPrev']);
    
        // $this->loadComponent('LogRegister');

        $this->loadComponent('ResourceManager');
    
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Orders', 'Appointments']
        ];
        $orderAppointments = $this->paginate($this->OrderAppointments);

        $this->set(compact('orderAppointments'));
        $this->set('_serialize', ['orderAppointments']);
    }

    /**
     * View method
     *
     * @param string|null $id Order Appointment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $orderAppointment = $this->OrderAppointments->get($id, [
            'contain' => ['Orders', 'Appointments']
        ]);

        $this->set('orderAppointment', $orderAppointment);
        $this->set('_serialize', ['orderAppointment']);
    }





    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderAppointment = $this->OrderAppointments->newEntity();
        if ($this->request->is('post')) {
            $orderAppointment = $this->OrderAppointments->patchEntity($orderAppointment, $this->request->data);
            if ($this->OrderAppointments->save($orderAppointment)) {
                $this->Flash->success(__('The order appointment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order appointment could not be saved. Please, try again.'));
            }
        }
        $orders = $this->OrderAppointments->Orders->find('list', ['limit' => 200]);
        $appointments = $this->OrderAppointments->Appointments->find('list', ['limit' => 200]);
        $this->set(compact('orderAppointment', 'orders', 'appointments'));
        $this->set('_serialize', ['orderAppointment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Appointment id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $orderAppointment = $this->OrderAppointments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderAppointment = $this->OrderAppointments->patchEntity($orderAppointment, $this->request->data);
            if ($this->OrderAppointments->save($orderAppointment)) {
                $this->Flash->success(__('The order appointment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order appointment could not be saved. Please, try again.'));
            }
        }
        $orders = $this->OrderAppointments->Orders->find('list', ['limit' => 200]);
        $appointments = $this->OrderAppointments->Appointments->find('list', ['limit' => 200]);
        $this->set(compact('orderAppointment', 'orders', 'appointments'));
        $this->set('_serialize', ['orderAppointment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Appointment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderAppointment = $this->OrderAppointments->get($id);
        if ($this->OrderAppointments->delete($orderAppointment)) {
            $this->Flash->success(__('The order appointment has been deleted.'));
        } else {
            $this->Flash->error(__('The order appointment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Julián Andrés Muñoz Cardozo
     * 2016-08-09 08:27:04
     * Funcion que consulta si una cita se ha relacionado con una orden
     */
    public function getOrderAppoinment()
    {
        $data = $this->request->data;

        // SELECT * FROM appointment_dates WHERE '2016-07-14 22:30:00' BETWEEN date_time_ini AND date_time_end;

        $getAppointments = $this->OrderAppointments->find('all',[
            'conditions'=>['OrderAppointments.appointments_id' => $data['appointments_id']],
        ])->first();

        if($getAppointments){

            $success = true;

            $this->set(compact('success','getAppointments'));
           
        }else{

            $success = false;


            $this->set(compact('success','errors'));

        }
    }



    //funcion para generar el sticker.

    public function printSticker($data = null)
    {

        if(!empty($this->request->data) && $data == null){
            $data = $this->request->data;
            $person = $data['order']['patient']['person'];

            $externalSpecialist = $data['order']['external_specialist'];

            $study = $data['appointment']['study'];

            $appointment = $data['appointment'];

            $attentions = $data['appointment']['attentions'][0];

            $date = $attentions['date_time_ini'];

            $dateFormat = current(explode('T', $date));

            $identification = $person['identification'];

            $clients = $data['order']['client'];

            $order = $data['order'];

            $retornar = false;
        }
        else{
            $person = $data['person'];
            $identification = $person['identification'];
            $dateFormat= current(explode('T', $data['attentions']['date_time_ini']));
            $order = $data['order'];
            $clients = $data['client'];
            $externalSpecialist = $data['external_specialist'];
            $study=$data['study'];

            $retornar = true;

        }

        if($externalSpecialist == "" ){
           $externalSpecialist['name'] = "__________________________________"; 
        }
            


        // el archivo debe ser prn.
        $extension = 'prn';


        $datos_sticker = [
            "nombre"=>$person['first_name'].' '.$person['middle_name'],
            
            "apellido"=> $person['last_name'].' '.$person['last_name_two'],

            "identification"=>$identification,
            "fecha"=>$dateFormat,
            "telefono"=>$person['phone'],
            "numestudio"=>$order['order_consec'],
            "entidad"=>$clients['name'],
            "medico"=>$externalSpecialist['name'],
            "codestudio"=>$study['cup'],
            "nombreestudio"=>$study['name'],

        ];


        $data = $datos_sticker;
        /****CREA LA PLANTILLA*****/
        //borra los stickers antiguos antes de crear el nombre
        $archivos = scandir(ROOT . DS . 'webroot' . DS . 'resources' . DS . 'sticker' . DS);

        foreach($archivos as $file){
            if($file != "plantilla.txt" && $file != "." && $file != ".." && $file != ".DS_Store"){
                unlink(ROOT . DS . 'webroot' . DS . 'resources' . DS . 'sticker' . DS . $file);
            }
        }
        // ya borro los archivos


        // Hace el quiebre de lineas correspondiente en caso de que el nombre del estudio sea muy largo 
        $nombreestudio = $data['nombreestudio'];
        
        $nombreestudio = wordwrap($nombreestudio, 49, "@", false);
        $estudio = explode( "@", $nombreestudio);

        // El valor del eje Y donde sera posicionada la linea
        $_y=620; 

        
        foreach ($estudio as $llave => $valor){
            $estudio[ $llave ] = "^FT25,".$_y."^A0N,25,23^FH\^FD".$estudio[$llave]."^FS";
            $_y+=40;
        }
        
        // Ya se hizo el quiere

        foreach($estudio as $llave => $valor){

            $estudio[$llave] = preg_replace(
                [
                    "/á/",
                    "/é/",
                    "/í/",
                    "/ó/",
                    "/ú/",
                    "/ñ/",
                    "/Á/",
                    "/É/",
                    "/Í/",
                    "/Ó/",
                    "/Ú/",
                    "/Ñ/"
                ]
                ,
                [
                    "\A0",
                    "\82",
                    "\A1",
                    "\A2",
                    "\A3",
                    "\A4",
                    "A",
                    "E",
                    "I",
                    "O",
                    "U",
                    "N"
                ]
                , $valor);
        }

        //ya organizo el nombre del estudio
        
        //Obtiene la plantilla de la impresion
        $plantilla = file_get_contents(ROOT . DS . 'webroot' . DS . 'resources' . DS . 'sticker' . DS . 'plantilla.txt');

        //reemplaza los valores en la plantilla
        $plantilla = preg_replace('/{{nombre}}/', $data['nombre'], $plantilla);
        $plantilla = preg_replace('/{{identificacion}}/', $data['identification'], $plantilla);
        $plantilla = preg_replace('/{{fecha}}/', $data['fecha'], $plantilla);
        $plantilla = preg_replace('/{{telefono}}/', $data['telefono'], $plantilla);
        $plantilla = preg_replace('/{{orden}}/', $data['numestudio'], $plantilla);
        $plantilla = preg_replace('/{{cliente}}/', $data['entidad'], $plantilla);
        $plantilla = preg_replace('/{{nombreespecialista}}/', $data['medico'], $plantilla);
        $plantilla = preg_replace('/{{codstudio}}/', $data['codestudio'], $plantilla);
        $plantilla = preg_replace('/{{apellido}}/', $data['apellido'], $plantilla);
        
        //Si el nombre es muy largo reacomoda la plantilla
        if(count($estudio) < 2){
            $plantilla = preg_replace('/{{nombreestudio}}/', $estudio[0], $plantilla);
            $plantilla = preg_replace('/{{mas}}/', "", $plantilla);
        }
        else{
            $plantilla = preg_replace('/{{nombreestudio}}/', $estudio[0], $plantilla);
            $_mas="";
            for($i=1; $i<count($estudio); $i++){
                $_mas.= PHP_EOL . $estudio[$i];
            }
            $plantilla = preg_replace('/{{mas}}/', $_mas, $plantilla);
        }

        $stringBody = $plantilla;
        /*********/
       
        
         /**
         * Guardar un archivo
         */

        $storedFileName =  $this->ResourceManager->createFile($stringBody, $extension, $identification, 'sticker');

      
            if($storedFileName ){

                $success = true;

                $this->set(compact('success','errors','storedFileName'));

                 if(empty($this->request->data)){
                 return $storedFileName;
                    }
            }else{

                $success = false;

                $errors = $getAppointments->errors();

                $this->set(compact('success','errors','storedFileName'));
                if(empty($this->request->data)){
                    return ['errors'=>$errors, 'storedFileName'=>$storedFileName];
                }

            }
        


        //$this->downloadPrev($storedFileName['storedFileName']);

    }

    public function downloadPrev($name){

        $this->autoRender = false;

        $this->response->file(WWW_ROOT.'/resources/sticker/'.$name, array('download' => true, 'name' => $name));

    }


}
