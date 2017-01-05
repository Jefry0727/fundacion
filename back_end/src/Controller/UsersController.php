<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;



/**
 * 
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{   


    public function initialize()
    {
        
        parent::initialize();
        $this->Auth->allow(['token','getUsersInventory', 'getAllUsers', 'getUserCashBox', 'getUserAll']);
    }

    public function getUserCashBox()
    {
        $users = $this->Users->find('all', ['conditions'=>['Users.roles_id'=>2], 'contain'=>['People'], 'fields'=>['Users.id', 'Users.username', 'Users.roles_id', 'People.id', 'People.first_name', 'People.last_name']])->toArray();

        if($users)
        {
            $success = true;

            $this->set(compact('success', 'users'));

        }else{

            $success = false;

            $this->set(compact('success'));
        }
    }

    /**
     * Obtiene todos los usuario del sistema. 
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-22
     * @datetime 2016-12-22T09:01:16-0500
     * @return   [type]                   [description]
     */
    public function getAll(){


        $users = $this->Users->find('all', 
            ['contain'=>['Roles', 'People','Centers'], 
             'conditions'=>['Roles.id <>' => 7]
            ]);

        $total = $this->Users->find('all',['conditions'=>['Users.roles_id <>' => 7]])->count();

        foreach ($users as $user) {
           
            $user->person->birthdate = $user->person->birthdate->i18nFormat('YYYY-MM-dd'); 
        }

        if($users)
        {
            $success = true;

                $this->set(compact('success', 'users', 'total')); 

        }else{

            $success = false;

            $errors = $users->errors();

            $this->set(compact('success', 'errors'));
        }

    }


    /**
     * Obtiene todos los usuario con paginacion
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-22
     * @datetime 2016-12-22T08:58:25-0500
     * @return   [type]                   [description]
     */
    public function getAllUsers()
    {
        $data = $this->request->data;

        $offset = $data['offset'];

        $users = $this->Users->find('all', [ 'limit' => 10, 'offset' => $offset ,'contain'=>['Roles', 'People','Centers'], 'conditions'=>['Roles.id <>' => 7]]);

        $total = $this->Users->find('all',['conditions'=>['Users.roles_id <>' => 7]])->count();


        foreach ($users as $user) {
           
            $user->person->birthdate = $user->person->birthdate->i18nFormat('YYYY-MM-dd'); 
          
        }

        if($users)
        {

            $success = true;

                $this->set(compact('success', 'users', 'total'));
          

        }else{

            $success = false;

            $errors = $users->errors();

            $this->set(compact('success', 'errors'));
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Roles', 'People','Centers']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'People','Centers']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    // /**
    //  * Add method
    //  *
    //  * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
    //  */
    // public function add()
    // {
    //     $user = $this->Users->newEntity();
    //     if ($this->request->is('post')) {
    //         $user = $this->Users->patchEntity($user, $this->request->data);
    //         if ($this->Users->save($user)) {
    //             $this->Flash->success(__('The user has been saved.'));
    //             return $this->redirect(['action' => 'index']);
    //         } else {
    //             $this->Flash->error(__('The user could not be saved. Please, try again.'));
    //         }
    //     }
    //     $roles = $this->Users->Roles->find('list', ['limit' => 200]);
    //     $people = $this->Users->People->find('list', ['limit' => 200]);
    //     $this->set(compact('user', 'roles', 'people'));
    //     $this->set('_serialize', ['user']);
    // }


    public function add()
    {
        $this->Crud->on('afterSave', function(Event $event) {

            if ($event->subject->created) {
            
                $this->set('data', [
            
                    'id' => $event->subject->entity->id,
            
                    'token' => JWT::encode(
                        [
                            'sub' => $event->subject->entity->id,
                            'exp' =>  time() + 604800
                        ],
            
                    Security::salt())
            
                ]);
            
                $this->Crud->action()->config('serialize.data', 'data');
            
            }
        });
        return $this->Crud->execute();
    }


    public function token(){

        $user = $this->Auth->identify();
                
        if (!$user) {
            throw new UnauthorizedException('Nombre de usuario o contraseña invalido');
        }

        $this->loadModel('People');

        $person = $this->People->get($user['people_id']);

        $this->set([
            'success' => true,
            'data' => [
                'token' => JWT::encode([
                    'sub' => $user['id'],
                    'user'=> $user,
                    'person' => $person,
                    'exp' =>  time() + 604800
                ],
                Security::salt())
            ],
            '_serialize' => ['success', 'data']
        ]);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editUser($id = null)
    {   $data=$this->request->data;
        if(!empty($data['action']) && $data['action'] =='restore'){
            if($this->Auth->user('roles_id')!= 1){
               $success = false;
               $message = "Usuario no autorizado para realizar esta acción";
               $this->set(compact('success', 'message'));
            }else{
                 $data =  $this->request->data;

                $id = $data['id'];

                $user = $this->Users->get($id, [
                    'contain' => []
                ]);

                unset($data['center']);
                unset($data['person']);
                unset($data['role']);

                if ($this->request->is(['patch', 'post', 'put'])) {

                    $user = $this->Users->patchEntity($user, $data);

                    if ($this->Users->save($user)) {

                        $success = true;

                        $this->set(compact('success', 'user'));
                        
                    } else {

                       $success = false;

                       $errors = $user->errors();

                       $this->set(compact('success', 'errors'));
                    }
                }
            }
        }
        else{
            $data =  $this->request->data;

            $id = $data['id'];

            $user = $this->Users->get($id, [
                'contain' => []
            ]);

            unset($data['center']);
            unset($data['person']);
            unset($data['role']);

            if ($this->request->is(['patch', 'post', 'put'])) {

                $user = $this->Users->patchEntity($user, $data);

                if ($this->Users->save($user)) {

                    $success = true;

                    $this->set(compact('success', 'user'));
                    
                } else {

                   $success = false;

                   $errors = $user->errors();

                   $this->set(compact('success', 'errors'));
                }
            }
        }

     
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    public function addUsers()
    {
        $person = $this->Users->newEntity();

        if ($this->request->is('post')) {

            $person = $this->Users->patchEntity($person, $this->request->data);

            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";

            $pass = array(); //remember to declare $pass as an array

            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

            for ($i = 0; $i < 10; $i++) {

                $n = rand(0, $alphaLength);

                $pass[] = $alphabet[$n];
            }



            $pass =  implode($pass); //turn the array into a string


            $person['password'] = $pass;

            if ($this->Users->save($person)) {

            $success = true;

            $this->set(compact('success','person'));
                            
            
            } else {    

                $success = false;

                $errors = $person->errors();

                $this->set(compact('success','errors'));
            }
        }
    }
    
    /**
     * Desativated user
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function desactivatedUsers()
    {
        $specialist = $this->request->data['user'];

        $id = $this->request->data['user']['id'];

        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        if ($this->request->is('post')) {

            $user = $this->Users->patchEntity($user, $specialist);

            // pr($specialist);
            
            // pr($user);

            $user['active'] = 0;

            if ($this->Users->save($user)) {

            $success = true;

            $this->set(compact('success','user'));
                            
            
            } else {    

                $success = false;

                $errors = $user->errors();

                $id = $this->request->data['id'];

                $this->set(compact('success','errors','id'));
            }
        }

    }

    public function activatedUsers()
    {
         $specialist = $this->request->data['user'];

        $id = $this->request->data['user']['id'];

        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        if ($this->request->is('post')) {

            $user = $this->Users->patchEntity($user, $specialist);

            // pr($specialist);
            
            // pr($user);

            $user['active'] = 1;

            if ($this->Users->save($user)) {

            $success = true;

            $this->set(compact('success','user'));
                            
            
            } else {    

                $success = false;

                $errors = $user->errors();

                $id = $this->request->data['id'];

                $this->set(compact('success','errors','id'));
            }
        }

    }

    public function getUsers()
    {   
        $data = $this->request->data;

        $offset = $data['offset'];

        $results = $this->Users->find('all', 

        [
        'contain' => ['People','Roles'],
        'limit' => 10, 'offset' => $offset ]

        );

        $total = $this->Users->find('all')->count();

        /**
         * Sending the result
         */
        $this->set(compact('results','total'));

    }

    public function getUsersInventory()
    {

        $results = $this->Users->find('all')
            ->select(['patients.id','Users.id', 'people.first_name','people.middle_name', 'people.last_name', 'people.last_name_two'])
            ->leftJoin('people', 'Users.people_id = people.id')
            ->leftJoin('patients', 'people.id = patients.people_id')
            ->where('patients.id IS NULL')
            ->group('Users.id')->toArray();
            
            

            for ($i=0; $i < count($results); $i++) { 

                $data[] = Array(


                    'id' => $results[$i]['id'],
                    'first_name' => $results[$i]['people']['middle_name'],
                    'middle_name' => $results[$i]['people']['middle_name'],
                    'last_name' => $results[$i]['people']['last_name'],
                    'last_name_two' => $results[$i]['people']['last_name_two']

                );

            }
        /**
         * Sending the result
         * 
         */
        $this->set(compact('data'));

    }
   //UserController que esta en el back-end
    public function getUserAll()
    {

        $data = $this->request->data;//recibe la informaciòn que venga por post

        $id = $data['id'];

        $users = $this->Users->find('all');//trae los datos de la base de datos
                        //nombre de la tabla en la base de datos

        if($users){

            $success = true;//si hay exito al traer los datos

            $this->set(compact('success', 'users'));//manda los datos a la vista para mostrar
        }else{

            $success = false;

            $errors = $users->errors();

            $this->set(compact('success', 'errors'));
        }
    }

    public function getDate()
    {
        $users= $this->Users->find('all');

        if($users){
            $success = true;
            $this->set(compact('success','users'));
        }else{
            $success = false;
            $error = $users->errors();
            $this->set(compact('success','error'));
        }
    }


    public function getUserById(){

        $id = $this->request->data['id'];

        $user = $this->Users->find('all',['contain'=>['People'],'conditions'=>['Users.id '=> $id]])->first();

         if($user){
            $success = true;
            $this->set(compact('success','user'));
        }else{
            $success = false;
            $error = $user->errors();
            $this->set(compact('success','error'));
        }


    }
}
