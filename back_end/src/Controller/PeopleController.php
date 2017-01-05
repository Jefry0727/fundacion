<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * People Controller
 *
 * @property \App\Model\Table\PeopleTable $People
 */
class PeopleController extends AppController
{
     public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['index',
                          
                            'getLastPeople',
                            'getPeoples', 
                            'getTypeDocument', 
                            'addUserPeople', 
                            'editUserPeople', 
                            'deleteUserPeople']
                      );

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
            'contain' => ['DocumentTypes']
        ];
        $people = $this->paginate($this->People);

        $this->set(compact('people'));
        $this->set('_serialize', ['people']);
    }

    public function getTypeDocument()
    {
        $typeDocuments = $this->People->DocumentTypes->find('all')->toArray();

        if($typeDocuments)
        {
            $success = true;

            $this->set(compact('success', 'typeDocuments'));
        }else{

            $success = false;

            $errors = $typeDocuments->errors();

            $this->set(compact('success', 'errors'));
        }
    }

    /**
     * View method
     *
     * @param string|null $id Person id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $person = $this->People->get($id, [
            'contain' => ['DocumentTypes']
        ]);

        $this->set('person', $person);
        $this->set('_serialize', ['person']);
        return $person->toArray();
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $person = $this->People->newEntity();

        if ($this->request->is('post')) {

            $data = $this->request->data;
            foreach($data as $llave => $valor){
                  if(!empty($valor) && gettype($valor) == 'string'){
                    $data[$llave] = strtoupper($valor);
                }
            }
            $data['user_creation'] = $this->Auth->user('id');
             if(empty($data['user_creation'])){
          $data['user_creation'] = 1;
        }

            $person = $this->People->patchEntity($person, $data);

            if ($this->People->save($person)) {

            $success = true;

            $this->set(compact('success','person'));
                            
            
            } else {    

                $success = false;

                $errors = $person->errors();

                $this->set(compact('success','errors'));
            }
        }
       
    }

    public function addUserPeople()
    {
        $data = $this->request->data;

        // $data['municipalities_id'] = 1;

        $data['user_creation'] = $this->Auth->user('id');
        if(empty($data['user_creation'])){
          $data['user_creation'] = 1;
        }

        $person = $this->People->newEntity();

        if ($this->request->is('post')) {

            $person = $this->People->patchEntity($person, $data);

            if ($this->People->save($person)) {

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
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addPeople()
    {
        $person = $this->People->newEntity();

        if ($this->request->is('post')) {

            $data = $this->request->data;
            $data['user_creation'] = $this->Auth->user('id');
            if(empty($data['user_creation'])){
              $data['user_creation'] = 1;
             }

            unset($data['id']);
            //Pasa a mayusculas los datos de la persona que seran guardados
            foreach($data as $llave => $valor){
                  if(!empty($valor) && gettype($valor) == 'string'){
                    $data[$llave] = strtoupper($valor);
                }
            }


            $person = $this->People->patchEntity($person, $data);
            $person->gender = $data[ 'gender' ];



            if ($this->People->save($person)) {

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
     * [editUserPeople description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-14
     * @datetime 2016-09-14T17:00:09-0500
     * @return   [type]                   [edit User]
     */
    public function editUserPeople()
    {
        $data = $this->request->data;

        $id = $data['id'];


        $person = $this->People->get($id, [
            'contain' => []
        ]);

        // $person = $this->People->newEntity();

        if ($this->request->is(['patch', 'post', 'put']))  {
            //Pasa a mayusculas los datos de la persona que seran guardados
            foreach($data as $llave => $valor){
                if(!empty($valor) && gettype($valor) == 'string'){
                    $data[$llave] = strtoupper($valor);
                }
            }
            $data['user_creation'] = $this->Auth->user('id');
             if(empty($data['user_creation'])){
          $data['user_creation'] = 1;
        }
            $person = $this->People->patchEntity($person, $data);


            if ($this->People->save($person)) {
                        
                $success = true;

                $this->set(compact('success','person'));
                            
            
            } else {    

                $success = false;

                $errors = $person->errors();

                $this->set(compact('success','errors'));
            }
        }
    }

    public function deleteUserPeople($id = null)
    {
        $id =  $this->request->data['id'];

        $this->request->allowMethod(['post', 'delete']);

        $person = $this->People->get($id);

        if ($this->People->delete($person)) {
           
            $success = true;

            $this->set(compact('success'));

        } else {
            
            $success = false;

            $errors = $person->errors();

            $this->set(compact('success', 'errors'));

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

        $person = $this->People->get($id, [
            'contain' => []
        ]);
        $person['user_creation']= 1;

        // $person = $this->People->newEntity();

        if ($this->request->is(['patch', 'post', 'put']))  {
        
        $data['user_creation'] = $this->Auth->user('id');
        if(empty($data['user_creation'])){
          $data['user_creation'] = 1;
        }
            
            foreach($data as $llave => $valor){
                  if(!empty($valor) && gettype($valor) == 'string'){
                    $data[$llave] = strtoupper($valor);
                }
             }

            $pesonToEdit = $data;

             unset($pesonToEdit['users']);
             unset($pesonToEdit['patients']);
            $person = $this->People->patchEntity($person, $pesonToEdit);

            if ($this->People->save($person)) {
                        
                
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
     * Delete method
     *
     * @param string|null $id Person id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $person = $this->People->get($id);
        if ($this->People->delete($person)) {
            $this->Flash->success(__('The person has been deleted.'));
        } else {
            $this->Flash->error(__('The person could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function getLastPeople(){

            $results = $this->People->find()->last();
            // View
            $this->set(compact('results'));

    }

    /**
     * Function to get all the parent permissions with it's child permissions
     * @return [type] [description]
     */
    public function getPeoples(){

        $id = $this->request->data['id'];

        /**
         * All parent People
         * @var Array
         */
        $results = $this->People->find('all',['conditions'=>['People.id' => $id]]);

        foreach ($results as $result) {
           
            $result->birthdate = $result->birthdate->i18nFormat('yyyy/MM/dd');
        
            // Time::setJsonEncodeFormat('yyyy-MM-dd HH:mm:ss');
        }

        /**
         * Sending the result
         */
        $this->set(compact('result'));

    }

    public function searchPeople(){
        $doc = $this->request->data['id'];

        $people = $this->People->find('all',['contain'=>['Municipalities','Patients', 'Users','Gender'],'conditions'=>['People.identification'=>$doc]])->first();

        if( !empty( $this->request->data['type'] ) && $this->request->data['type'] == 1 ){
          
          $this->loadModel('Clients');
          $people=$this->Clients->find()
                        ->where([
                            'state'=>0,
                            'types_client_id'=>2,
                            'nit'=>$doc
                          ])
                        ->first();

          // obtener el regimen
          $this->loadModel('Regimes');
          $regimesId= $this->Regimes->find()
                                    ->select(['id'])
                                    ->where([
                                        'regime LIKE'=>'%otro%'
                                      ])
                                    ->first()
                                    ->toArray();

          $people['regimes_id'] = $regimesId['id'];
          // Tipo de la afiliacion QUEMADO
          $people['affiliation_type'] = 2;

          $people['first_name'] = $people['name'];
          $people['middle_name'] ='';
          $people['last_name']  = '';
          $people['last_name_two'] = '';
          $people['gender'] = '';
          $people['entity'] = true;

        }

        if($people){

                $success = true;
                $people = $people->toArray();
                $this->set(compact('success','people'));


        }else {    

                $success = false;
                if( !empty( $people ) ){

                    $errors = $people->errors();

                }else{
                    $errors = [];
                }
                

                $this->set(compact('success','errors'));
            }
    }

    public function getPeopleByIdentification(){

        $identification = $this->request->data['identification'];
        $persona = $this->People->find(
            'all',
            [
                'conditions' => [ 'identification' => $identification ]
            ]
        )->first();
        
        if( $persona ){
            
            $success = true;
            $this->set( compact( 'success', 'persona' ) );
        
        }
        else{

            $success = false;
            $this->set( compact( 'success', 'persona' ) );

        }

    }


    /*
      Carlos Felipe Aguirre Taborda GL STUDIOS S.A.S
      Fecha: 2017-01-03 09:13:47
      Tipo de dato de retorno:  void
      Descripción: Busca el usuario y el registro de la personna por su nombre
    */
    public function searchUsersByName(){

        $name = $this->request->data[ 'name' ];
        $connection = ConnectionManager::get('default');
        $results = $connection->execute("
            SELECT 
            	CONCAT(
            		people.first_name,' ',
            		people.middle_name,' ',
            		people.last_name,' ',
            		people.last_name_two
            	) as name,
            	users.id
            FROM people
            	INNER JOIN users
                ON
            		people.id = users.people_id
                INNER JOIN roles
                ON
                    users.roles_id = roles.id
            WHERE 
            	CONCAT(
            		people.first_name,' ',
            		people.middle_name,' ',
            		people.last_name,' ',
            		people.last_name_two
            	) LIKE '%". $name ."%'
            AND
                users.active = 0
            
            LIMIT 30;
        ")->fetchAll('assoc');

        $this->set( compact( 'results' ) );
    }


}
