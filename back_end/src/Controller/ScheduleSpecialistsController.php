<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ScheduleSpecialists Controller
 *
 * @property \App\Model\Table\ScheduleSpecialistsTable $ScheduleSpecialists
 */
class ScheduleSpecialistsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Specialists', 'ScheduleSpecialistTypes']
        ];
        $scheduleSpecialists = $this->paginate($this->ScheduleSpecialists);

        $this->set(compact('scheduleSpecialists'));
        $this->set('_serialize', ['scheduleSpecialists']);
    }

    /**
     * View method
     *
     * @param string|null $id Schedule Specialist id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $scheduleSpecialist = $this->ScheduleSpecialists->get($id, [
            'contain' => ['Specialists', 'ScheduleSpecialistTypes']
        ]);

        $this->set('scheduleSpecialist', $scheduleSpecialist);
        $this->set('_serialize', ['scheduleSpecialist']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $scheduleSpecialist = $this->ScheduleSpecialists->newEntity();

        if ($this->request->is('post')) {

            $scheduleSpecialist = $this->ScheduleSpecialists->patchEntity($scheduleSpecialist, $this->request->data);


            if ($this->ScheduleSpecialists->save($scheduleSpecialist)) {

                $success = true;
                $this->set(compact('scheduleSpecialist'));
        

            } else {
                 $errors = $scheduleSpecialist->errors();
   
                 $this->set(compact('errors'));


            }

        }

        

    }

    /**
     * Edit method
     *
     * @param string|null $id Schedule Specialist id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $scheduleSpecialist = $this->ScheduleSpecialists->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $scheduleSpecialist = $this->ScheduleSpecialists->patchEntity($scheduleSpecialist, $this->request->data);
            if ($this->ScheduleSpecialists->save($scheduleSpecialist)) {
                $this->Flash->success(__('The schedule specialist has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The schedule specialist could not be saved. Please, try again.'));
            }
        }
        $specialists = $this->ScheduleSpecialists->Specialists->find('list', ['limit' => 200]);
        $scheduleSpecialistTypes = $this->ScheduleSpecialists->ScheduleSpecialistTypes->find('list', ['limit' => 200]);
        $this->set(compact('scheduleSpecialist', 'specialists', 'scheduleSpecialistTypes'));
        $this->set('_serialize', ['scheduleSpecialist']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Schedule Specialist id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $scheduleSpecialist = $this->ScheduleSpecialists->get($id);
        if ($this->ScheduleSpecialists->delete($scheduleSpecialist)) {
            $this->Flash->success(__('The schedule specialist has been deleted.'));
        } else {
            $this->Flash->error(__('The schedule specialist could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
