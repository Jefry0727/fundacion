<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * SpecialistRole Controller
 *
 * @property \App\Model\Table\SpecialistRoleTable $SpecialistRole
 */
class SpecialistRoleController extends AppController
{


     public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['getSpecialistRole']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Specialists', 'Specializations']
        ];
        $specialistRole = $this->paginate($this->SpecialistRole);

        $this->set(compact('specialistRole'));
        $this->set('_serialize', ['specialistRole']);
    }

    /**
     * View method
     *
     * @param string|null $id Specialist Role id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $specialistRole = $this->SpecialistRole->get($id, [
            'contain' => ['Specialists', 'Specializations']
        ]);

        $this->set('specialistRole', $specialistRole);
        $this->set('_serialize', ['specialistRole']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $specialistRole = $this->SpecialistRole->newEntity();
        if ($this->request->is('post')) {
            $specialistRole = $this->SpecialistRole->patchEntity($specialistRole, $this->request->data);
            if ($this->SpecialistRole->save($specialistRole)) {
                $this->Flash->success(__('The specialist role has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The specialist role could not be saved. Please, try again.'));
            }
        }
        $specialists = $this->SpecialistRole->Specialists->find('list', ['limit' => 200]);
        $specializations = $this->SpecialistRole->Specializations->find('list', ['limit' => 200]);
        $this->set(compact('specialistRole', 'specialists', 'specializations'));
        $this->set('_serialize', ['specialistRole']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Specialist Role id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $specialistRole = $this->SpecialistRole->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $specialistRole = $this->SpecialistRole->patchEntity($specialistRole, $this->request->data);
            if ($this->SpecialistRole->save($specialistRole)) {
                $this->Flash->success(__('The specialist role has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The specialist role could not be saved. Please, try again.'));
            }
        }
        $specialists = $this->SpecialistRole->Specialists->find('list', ['limit' => 200]);
        $specializations = $this->SpecialistRole->Specializations->find('list', ['limit' => 200]);
        $this->set(compact('specialistRole', 'specialists', 'specializations'));
        $this->set('_serialize', ['specialistRole']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Specialist Role id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {   
        $conn = ConnectionManager::get('default');

        $this->request->allowMethod(['post', 'delete']);
        $specialistRole = $this->SpecialistRole->get($id);
        if ($this->SpecialistRole->delete($specialistRole)) {
            $this->Flash->success(__('The specialist role has been deleted.'));
        } else {
            $this->Flash->error(__('The specialist role could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

/**
 * OBTIENE LOS SPECIALISTAS SEGUN UN ROL ASIGNADO
 * @author Deicy Rojas <deirojas.1@gmail.com>
 * @date     2016-09-13
 * @datetime 2016-09-13T11:47:21-0500
 * @return   [type]                   [description]
 */
    public function getSpecialistRole()
    {    

        $this->loadModel('People');

        $this->loadModel('Specialists');

        $conn = ConnectionManager::get('default');

        $data = $this->request->data;

        $id = $data['id'];

        $specialistsList = $conn->execute("
        SELECT * FROM specialist_role
        INNER JOIN specialists ON specialists.id = specialist_role.specialists_id 
        INNER JOIN people ON people.id =  specialists.people_id
        WHERE specialist_role.specializations_id =".$id
        )->fetchAll('assoc');

        $this->set(compact('specialistsList'));
    }
}
