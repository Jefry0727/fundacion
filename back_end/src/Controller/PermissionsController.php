<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Permissions Controller
 *
 * @property \App\Model\Table\PermissionsTable $Permissions
 */
class PermissionsController extends AppController
{


    // In a controller
        
    // Make the new component available at $this->Math,
    // as well as the standard $this->Csrf
    public function initialize()
    {
        parent::initialize();
    
        $this->Auth->allow(['index','getAllPermissions','updatePermissionRole','verLog','getAllPermissionsMenu','getPermissions']);

    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => []
        ];
        $permissions = $this->paginate($this->Permissions);

        $this->set(compact('permissions'));
        $this->set('_serialize', ['permissions']);
    }

    /**
     * View method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $permission = $this->Permissions->get($id, [
            'contain' => ['ParentPermissions', 'Roles']
        ]);

        $this->set('permission', $permission);
        $this->set('_serialize', ['permission']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $permission = $this->Permissions->newEntity();
        if ($this->request->is('post')) {
            $permission = $this->Permissions->patchEntity($permission, $this->request->data);
            if ($this->Permissions->save($permission)) {
                $this->Flash->success(__('The permission has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The permission could not be saved. Please, try again.'));
            }
        }
        $parentPermissions = $this->Permissions->ParentPermissions->find('list', ['limit' => 200]);
        $roles = $this->Permissions->Roles->find('list', ['limit' => 200]);
        $this->set(compact('permission', 'parentPermissions', 'roles'));
        $this->set('_serialize', ['permission']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $permission = $this->Permissions->get($id, [
            'contain' => ['Roles']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $permission = $this->Permissions->patchEntity($permission, $this->request->data);
            if ($this->Permissions->save($permission)) {
                $this->Flash->success(__('The permission has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The permission could not be saved. Please, try again.'));
            }
        }
        $parentPermissions = $this->Permissions->ParentPermissions->find('list', ['limit' => 200]);
        $roles = $this->Permissions->Roles->find('list', ['limit' => 200]);
        $this->set(compact('permission', 'parentPermissions', 'roles'));
        $this->set('_serialize', ['permission']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $permission = $this->Permissions->get($id);
        if ($this->Permissions->delete($permission)) {
            $this->Flash->success(__('The permission has been deleted.'));
        } else {
            $this->Flash->error(__('The permission could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    /**
     * Function that return complete permission by role id
     * @param  Integer $roleId 
     * @return Array         
     */
    public function getCompletePermissions($roleId){


        /**
         * All parent Permissions
         * @var Array
         */
        $results = $this->Permissions->find('all',['conditions'=>['Permissions.parent_permission_id' => 0]])->toArray();

        /**
         * Var with all the results
         * @var Array
         */
        $completePermissions = Array();


        /**
         * Counter to asign references to the new array
         * @var integer
         */
        $counter = 0;

        /**
         * Iteration in the results
         */
        foreach ($results as $result) {

            /**
             * Set the parent permission
             */
            $completePermissions[$counter]['permission'] = $result; 


            /**
             * Parent Permission Id
             * @var Integer
             */
            $parentPermissionId = $result['id'];

            /**
             * Query the child permissions
             * @var Array
             */
            $childPermissions = $this->Permissions->find('all',['conditions'=>['Permissions.parent_permission_id'=> $parentPermissionId]])->toArray();


             /**
              * Cheking if role has current Parent permission and asing result to current array position
              */
            $completePermissions[$counter]['permission']['roleHasPermission'] = $this->roleHasParentPermission($roleId,$childPermissions);


            /**
             * iterating through child permissions
             */
            foreach ($childPermissions as $childPermission) {

                /**
                 * Cheking if role has current permission and asing result to current array position 
                 */
                $childPermission['roleHasChildPermission'] = $this->roleHasPermission($roleId, $childPermission['id']);
    
                /**
                 * Set of child permissions
                 */
                $completePermissions[$counter]['childPermissions'][] = $childPermission; 

            }   
  
            /**
             * Add 1 to counter
             */
            $counter = $counter + 1;    
        }


        return $completePermissions;


    }
    

    /**
     * Function to get all the parent permissions with it's child permissions
     * @return [type] [description]
     */
    public function getAllPermissions(){

        /**
         * Role Identifier
         * @var Integer
         */
        $roleId = $this->request->data['roleId'];
            
        /**
         * Complete permissions
         * @var Array
         */
        $completePermissions = $this->getCompletePermissions($roleId);
         
        /**
         * Sending the result
         */
        $this->set(compact('completePermissions'));

        // pr($completePermissions);

    }

      /**
     * Function to get all the parent permissions with it's child permissions
     * @return [type] [description]
     */
    public function getPermissions(){

            
        /**
         * Complete permissions
         * @var Array
         */
        $results = $this->Permissions->find('all',['conditions'=>['Permissions.parent_permission_id'=> 0],
            'order' => ['Permissions.name' => 'ASC']
            ])->toArray();

        /**
         * Sending the result
         */
        $this->set(compact('results'));

        // pr($completePermissions);

    }



    // public function ver(){

    //     /**
    //      * Loading PermissionsRoles model
    //      */
    //     $this->loadModel('PermissionsRoles');



    //     $permissions = $this->PermissionsRoles->find('all',['conditions'=>['PermissionsRoles.permissions_id in '=> $ids, 'PermissionsRoles.roles_id' => $roleId]])->toArray();

    //     pr($permissions);

    // }


    /**
     * Function that verify if a role has a parent permission related
     * @param  Integer $roleId            Role identifier
     * @param  Integer $childPermissionId permission identifier
     * @return Boolean                    if has true, if not false
     */
    public function roleHasParentPermission($roleId, $childPermissions){

        /**
         * Loading PermissionsRoles model
         */
        $this->loadModel('PermissionsRoles');

        /**
         * Permission Identifiers
         * @var Array
         */
        $ids = Array();

        /**
         * Getting child permission ids
         */
        foreach ($childPermissions as $childPermission) {

           /**
            * Asign id to ids array
            */
           $ids[] = $childPermission['id'];

        }

        $permissions = Array();

        if(count($ids) > 0){

            /**
             * Query if has a permission related
             * @var Array
             */
            $permissions = $this->PermissionsRoles->find('all',['conditions'=>['PermissionsRoles.permissions_id in '=> $ids, 'PermissionsRoles.roles_id' => $roleId]])->toArray();
           
        }

        /**
         * returning result
         */
        if(count($permissions) > 0){

            return true;

        }else{

            return false;
        }

    }

    /**
     * Function that verifies if a role has a permission related
     * @param  Integer $roleId            Role identifier
     * @param  Integer $childPermissionId permission identifier
     * @return Boolean                    if has true, if not false
     */
    public function roleHasPermission($roleId, $childPermissionId){

        /**
         * Loading PermissionsRoles model
         */
        $this->loadModel('PermissionsRoles');

        /**
         * Query if has a permission related
         * @var Array
         */
        $permissions = $this->PermissionsRoles->find('all',['conditions'=>['PermissionsRoles.permissions_id '=> $childPermissionId, 'PermissionsRoles.roles_id' => $roleId]])->toArray();

        /**
         * returning result
         */
        if($permissions){

            return true;

        }else{

            return false;
        }


    }


    public function updatePermissionRole(){

        $updateData = $this->request->data;

        $roleId = $updateData['roleId'];

        $permissionId = $updateData['permissionId'];

        $roleHasChildPermission = $updateData['roleHasChildPermission'];


        $success = true;

        if($roleHasChildPermission){


            if($this->savePermissionRole($roleId, $permissionId)){

                $success = true;

            }else{

                $success = false;

            }
            


        }else{


            if($this->dropPermissionRole($roleId, $permissionId)){

                $success = true;

            }else{

                $success = false;

            }

        }



        $this->set(compact('success'));

    }   


    public function dropPermissionRole($roleId, $permissionId){


        /**
         * Loading PermissionsRoles model
         */
        $this->loadModel('PermissionsRoles');


        $permission = $this->PermissionsRoles->find('all', [
            'conditions' => ['PermissionsRoles.roles_id' => $roleId, 'PermissionsRoles.permissions_id' => $permissionId]
        ]);

        $permission = $permission->first();

        $entity = $this->PermissionsRoles->get($permission['id']);
        
        $result = $this->PermissionsRoles->delete($entity);

        if($result){
        
            return true;
        
        }else{

            return false;
        }

    }



    public function savePermissionRole($roleId, $permissionId){


        /**
         * Loading PermissionsRoles model
         */
        $this->loadModel('PermissionsRoles');


        $permission = $this->PermissionsRoles->newEntity();
       
        
            $permission = $this->PermissionsRoles->patchEntity($permission, Array('permissions_id'=>$permissionId,'roles_id'=>$roleId));
       
            if ($this->PermissionsRoles->save($permission)) {
                
                return true;

        
            } else {
       
                return false;
            }
    
    }

    /**
     * Function to get all the parent permissions with it's child permissions
     * @return [type] [description]
     */
    public function getAllPermissionsMenu(){

        /**
         * Complete permissions
         * @var Array
         */
        $this->loadModel('PermissionsRoles');

            $role = $this->request->data['idRole'];

            $id = $this->request->data['id'];

                /**
             * Complete permissions
             * @var Array
             */
            
            $results = $this->PermissionsRoles->find('all',

                [
                'contain' => ['Permissions'],
                'conditions'=>['Permissions.parent_permission_id'=> $id,'PermissionsRoles.roles_id' => $role],
                'order' => ['Permissions.id' => 'ASC']
                ])->toArray();


            /**
             * Sending the result
             */
            $this->set(compact('results'));

        // pr($completePermissions);

    }
}