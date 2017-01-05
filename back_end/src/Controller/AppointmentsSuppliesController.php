<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;


/**
 * AppointmentsSupplies Controller
 *
 * @property \App\Model\Table\AppointmentsSuppliesTable $AppointmentsSupplies
 */
class AppointmentsSuppliesController extends AppController
{


    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add','getById']);
    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
        'contain' => ['Appointments', 'ProductsStudies']
        ];
        $appointmentsSupplies = $this->paginate($this->AppointmentsSupplies);

        $this->set(compact('appointmentsSupplies'));
        $this->set('_serialize', ['appointmentsSupplies']);
    }

    /**
     * View method
     *
     * @param string|null $id Appointments Supply id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $appointmentsSupply = $this->AppointmentsSupplies->get($id, [
            'contain' => ['Appointments', 'ProductsStudies']
            ]);

        $this->set('appointmentsSupply', $appointmentsSupply);
        $this->set('_serialize', ['appointmentsSupply']);
    }



 /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
 public function add()
 {

    // $this->autoRender = false;
    // $idAppointment = '218';

    $idAppointment = $this->request->data['id'];

    $this->loadModel('ProductsStudies');
    $this->loadModel('Appointments');

    $conn = ConnectionManager::get('default');

        // se define como 1 cantidad inicial
    $appointmentList = $conn->execute("
        SELECT appointments.id as appointments_id, products_studies.id as products_studies_id
        FROM appointments LEFT JOIN studies ON appointments.studies_id = studies.id 
        LEFT JOIN products_studies ON studies.id =  products_studies.studies_id
        WHERE appointments.id = ".$idAppointment
        )->fetchAll('assoc'); 
    

    foreach ($appointmentList as $key => $value) {

        $supply = $this->AppointmentsSupplies->newEntity();

        $supply['appointments_id'] = $value['appointments_id'];


        if($value['products_studies_id'] != null){

            $supply['products_studies_id'] = $value['products_studies_id'];

            //$supply['users_id'] = $this->Auth->user('id');
            
            $supply['quantity'] = 1;

            $supply['cost'] = 0;

            if ($this->AppointmentsSupplies->save($supply)) {

                $success = true;


            } else {

                $success = false;

            }  

        }else{

                $success = true;
        }

    }

    $this->set(compact('success'));

}

public function getById(){

    $idAppointment = $this->request->data['idAppointment'];

    $rates_id = $this->request->data['rates_id'];

    $appointmentsSupply = $this->AppointmentsSupplies->find('all' , 
        ['contain' => ['ProductsStudies.Services'],
        'conditions'=>[
        'AppointmentsSupplies.appointments_id IN' => $idAppointment]])->toArray();

    $appointmentsSupply = json_decode(json_encode($appointmentsSupply), true);





    if ($appointmentsSupply) {

        // Obtiene el valor de cada servicio dependiendo de la tarifa
    
        $conection = ConnectionManager::get('default');

        for($i =0; $i < count($appointmentsSupply);$i++ ){
            $services_id[] = $appointmentsSupply[$i]['products_study']['servicises_id'];

            $res=$conection->execute(
                        'SELECT rate_services.value 
                         FROM rate_services INNER JOIN services ON rate_services.servicises_id = services.id
                         WHERE rate_services.rates_id = ' . $rates_id . ' AND rate_services.state = 1 AND services.id=' . $services_id[$i]
                    )->fetchAll('assoc');

            $services_value[] = $res[0];

            $appointmentsSupply[$i]['products_study']['service']['value'] = $services_value[$i]['value'];
            $appointmentsSupply[$i]['products_study']['product'] = $appointmentsSupply[$i]['products_study']['service'];
            $appointmentsSupply[$i]['products_study']['product']['cost'] = 0;

        }
        // Ya se obtuvo el valor de cada tarifa y se puso en el arreglo




        $success = true;

        $this->set(compact('success','appointmentsSupply'));

    }else{

        $success = false;

        $this->set(compact('success'));

    }

}


/**
 * Obtener todos los productos de acuerdo aun Id.
 * @return [type] [description]
 */
public function getByOneId(){

    $idAppointment = $this->request->data['idAppointment'];

  

    $appointmentsSupply = $this->AppointmentsSupplies->find('all' , 
        ['contain' => ['ProductsStudies.Services'],
        'conditions'=>[
        'AppointmentsSupplies.appointments_id' => $idAppointment]])->toArray();


    if ($appointmentsSupply) {

        $success = true;

        $this->set(compact('success','appointmentsSupply'));

    }else{

        $success = false;

        $this->set(compact('success'));

    }
}




    /**
     * Edit method
     *
     * @param string|null $id Appointments Supply id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found
     */
    public function edit($id = null)
    {

        $data = $this->request->data;

        $id = $data['id'];
        // $quantity = $data['quantity'];
        // $cost = $data['cost'];

        $appointmentsSupply = $this->AppointmentsSupplies->get($id);



        $appointmentsSupply = $this->AppointmentsSupplies->patchEntity($appointmentsSupply, $this->request->data);

        if ($this->AppointmentsSupplies->save($appointmentsSupply)) {

           $success = true;

           $this->set(compact('success','appointmentsSupply'));

       } else {

        $success = false;

        $errors = $appointmentsSupply->errors();

        $this->set(compact('success','errors'));


        

    }
}

    /**
     * Delete method
     *
     * @param string|null $id Appointments Supply id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $appointmentsSupply = $this->AppointmentsSupplies->get($id);
        if ($this->AppointmentsSupplies->delete($appointmentsSupply)) {
            $this->Flash->success(__('The appointments supply has been deleted.'));
        } else {
            $this->Flash->error(__('The appointments supply could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
