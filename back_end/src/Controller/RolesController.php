<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 */
class RolesController extends AppController
{   

    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['add','edit','index','delete', 'getRoles']);
    }



    public function getRoles()
    {
        $roles = $this->Roles->find('all')->toArray();

        if($roles)
        {
            $success = true;

            $this->set(compact('success', 'roles'));
        }else{

            $success = false;

            $errors = $roles->errors();

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
        $roles = $this->paginate($this->Roles);


        $this->set(compact('roles'));

        // $this->set('_serialize', ['roles']);
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => ['Permissions']
        ]);

        $this->set('role', $role);
        $this->set('_serialize', ['role']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {


        $role = $this->Roles->newEntity();

        if ($this->request->is('post')) {
            
            $role = $this->Roles->patchEntity($role, $this->request->data);
            
            $newRow =  $this->request->data;

            $newRow = $newRow['name']; 

            if ($this->Roles->save($role)) {
                        
                
                $success = true;
                $this->set(compact('success','role'));
                            
            
            } else {    

                $success = false;
                $errors = $role->errors();

                $this->set(compact('success','errors'));
            }
        }
    


    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
        
        $id = $this->request->data['id'];

        $role = $this->Roles->get($id, [
            'contain' => []
        ]);

        // $role = $this->Roles->newEntity();

        if ($this->request->is(['patch', 'post', 'put']))  {

            $role = $this->Roles->patchEntity($role, $this->request->data);

            if ($this->Roles->save($role)) {
                        
                
                $success = true;

                $this->set(compact('success','role'));
                            
            
            } else {    

                $success = false;

                $errors = $role->errors();

                $this->set(compact('success','errors'));
            }
        }

    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
        $id = $this->request->data['id'];

        $this->request->allowMethod(['post', 'delete']);

        $role = $this->Roles->get($id);

        if ($this->Roles->delete($role)) {
              
            $success = true;

            $this->set(compact('success','role'));
                        
        
        } else {    

            $success = false;

            $errors = $role->errors();

            $this->set(compact('success','errors'));
        }
    }
}
