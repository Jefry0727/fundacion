<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Municipalities Controller
 *
 * @property \App\Model\Table\MunicipalitiesTable $Municipalities
 */
class MunicipalitiesController extends AppController
{


public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add','edit','delete','index','getByDepartment']);
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Departments']
        ];
        $municipalities = $this->paginate($this->Municipalities);

        $this->set(compact('municipalities'));
        $this->set('_serialize', ['municipalities']);
    }



     /**
        Get all the Municipalities of a one department
    */
    public function getByDepartment(){

            $data = $this->request->data;

            $idDepartment  = $data['id'];        
        
            $municipalities = $this->Municipalities->find('all', ['conditions'=>['department_id' => $idDepartment]])->toArray();
        
         if ($municipalities) {
        
            $success = true;

            $this->set(compact('success','municipalities'));
       
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
        
    }
    /**
    *Get City by ID
    */

    public function getByMunicipality(){

            $data = $this->request->data;

            $id  = $data['id'];        
        
           $municipalities = $this->Municipalities->find('all', ['conditions'=>['Municipalities.id' => $id]])->toArray();
        
         if ($municipalities) {
        
            $success = true;

            $this->set(compact('success','municipalities'));
       
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
        
    }



    /**
     * View method
     *
     * @param string|null $id Municipality id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $municipality = $this->Municipalities->get($id, [
            'contain' => ['Departments']
        ]);

        $this->set('municipality', $municipality);
        $this->set('_serialize', ['municipality']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $municipality = $this->Municipalities->newEntity();
        if ($this->request->is('post')) {
            $municipality = $this->Municipalities->patchEntity($municipality, $this->request->data);
            if ($this->Municipalities->save($municipality)) {
                $this->Flash->success(__('The municipality has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The municipality could not be saved. Please, try again.'));
            }
        }
        $departments = $this->Municipalities->Departments->find('list', ['limit' => 200]);
        $this->set(compact('municipality', 'departments'));
        $this->set('_serialize', ['municipality']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Municipality id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $municipality = $this->Municipalities->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $municipality = $this->Municipalities->patchEntity($municipality, $this->request->data);
            if ($this->Municipalities->save($municipality)) {
                $this->Flash->success(__('The municipality has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The municipality could not be saved. Please, try again.'));
            }
        }
        $departments = $this->Municipalities->Departments->find('list', ['limit' => 200]);
        $this->set(compact('municipality', 'departments'));
        $this->set('_serialize', ['municipality']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Municipality id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $municipality = $this->Municipalities->get($id);
        if ($this->Municipalities->delete($municipality)) {
            $this->Flash->success(__('The municipality has been deleted.'));
        } else {
            $this->Flash->error(__('The municipality could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
