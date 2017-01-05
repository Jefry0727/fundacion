<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Datasource\ConnectionManager;

/**
 * AppointmentStates Controller
 *
 * @property \App\Model\Table\AppointmentStatesTable $AppointmentStates
 */
class AppointmentStatesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $appointmentStates = $this->paginate($this->AppointmentStates);

        $this->set(compact('appointmentStates'));
        $this->set('_serialize', ['appointmentStates']);
    }


    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['getAppointmentsDay']);
    }

    


    /**
     * View method
     *
     * @param string|null $id Appointment State id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $appointmentState = $this->AppointmentStates->get($id, [
            'contain' => []
        ]);

        $this->set('appointmentState', $appointmentState);
        $this->set('_serialize', ['appointmentState']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $appointmentState = $this->AppointmentStates->newEntity();
        if ($this->request->is('post')) {
            $appointmentState = $this->AppointmentStates->patchEntity($appointmentState, $this->request->data);
            if ($this->AppointmentStates->save($appointmentState)) {
                $this->Flash->success(__('The appointment state has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The appointment state could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('appointmentState'));
        $this->set('_serialize', ['appointmentState']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Appointment State id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $appointmentState = $this->AppointmentStates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appointmentState = $this->AppointmentStates->patchEntity($appointmentState, $this->request->data);
            if ($this->AppointmentStates->save($appointmentState)) {
                $this->Flash->success(__('The appointment state has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The appointment state could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('appointmentState'));
        $this->set('_serialize', ['appointmentState']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Appointment State id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $appointmentState = $this->AppointmentStates->get($id);
        if ($this->AppointmentStates->delete($appointmentState)) {
            $this->Flash->success(__('The appointment state has been deleted.'));
        } else {
            $this->Flash->error(__('The appointment state could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    /**
     * funcion para obtener las citas de un dia determinado
     * falta consultorio!!
     * @return [type] [description]
     */
    public function getAppointmentsDay(){

        $dateDay = $this->request->data['dateDay'];

        $idMedical = $this->request->data['idMedical'];

        $dateDay = $dateDay;

        $this->loadModel('AppointmentDates');

        $appointments =  $this->AppointmentDates->find('all',[

            'contain'       =>  ['Appointments.Studies','Users.People'],

            'conditions'    =>  [
            
                'DATE(AppointmentDates.date_time_ini) '        => $dateDay,
            
                'AppointmentDates.appointment_states_id IN' => [1,2,3],
                
                'AppointmentDates.id = (SELECT MAX(ad.id) FROM appointment_dates ad WHERE ad.appointments_id = Appointments.id)',

                'Appointments.medical_offices_id' => $idMedical

                ]
            ]

        )->toArray();

        $connection = ConnectionManager::get('default');


        foreach ($appointments as $appointment) {
            

            //Obtener el paciente del appointment
            $result[] = $connection->execute(
                "
                    SELECT concat(first_name,' ',middle_name,' ',last_name) as nombre  , identification FROM people 
                    INNER JOIN patients ON patients.people_id = people.id
                    RIGHT JOIN orders ON patients.id = orders.patients_id
                    RIGHT JOIN order_appointments ON orders.id =  order_appointments.orders_id
                    RIGHT JOIN appointments ON appointments.id = order_appointments.appointments_id
                    WHERE  appointments.id = " . $appointment->appointments_id
                )->fetchAll('assoc');

            //ya se obtuvo el nombre



            $appointment->date_time_ini = $appointment->date_time_ini->i18nFormat('yyyy-MM-dd').'T'.$appointment->date_time_ini->i18nFormat('HH:mm:ss');

            $appointment->date_time_end = $appointment->date_time_end->i18nFormat('yyyy-MM-dd').'T'.$appointment->date_time_end->i18nFormat('HH:mm:ss');

        }

        $appointments = json_decode(json_encode($appointments), true);
        
        //pone los nombres en la respuesta
        for( $i = 0; $i < count( $appointments ); $i++ ){
            $appointments[$i]['name'] = $result[$i][0]['nombre'];
            $appointments[$i]['identification'] = $result[$i][0]['identification'];
        }


        $this->set(compact('appointments'));

    }


}
