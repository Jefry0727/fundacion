<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Specialists Controller
 *
 * @property \App\Model\Table\SpecialistsTable $Specialists
 */
class SpecialistsController extends AppController
{   

     public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add','edit','index','delete','addSpecialist','getSpecialist', 'getAllSpecialist', 'getSpecialistResult','getSpecialistById']);

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
            'contain' => ['People', 'Users']
        ];
        $specialists = $this->paginate($this->Specialists);

        $this->set(compact('specialists'));
        $this->set('_serialize', ['specialists']);
    }


    public function saveFileSignature(){


        // $data = $this->request->data;

        // $file = $data['file'];


        $id = json_decode($this->request->data['id'], true);


        $signatures = $this->ResourceManager->getResources($id, 'specialist', 'specialist_signature');

        foreach ($signatures as $signature) {
              

            $this->ResourceManager->deleteResource($signature['id'], $signature['entity_id'], 'specialist');
         
        }

        /**
         * Guardar el archivo de firma
         */
        $result = $this->ResourceManager->saveResource($id, 'specialist', 'specialist_signature','specialist_signatures');

        $this->set(compact('result'));


        /**
         * Guardar un archivo
         */
         // $this->ResourceManager->saveResource(2, 'patients', 'profile_pic', '123456');



        // pr($this->ResourceManager->getResources(1, 'profile_pic'));

        // $content = "SVG content";

        // $this->ResourceManager->saveResourceCreateFile(1, 'studies_consents', 'consent_signature', 'consent_signatures', $file, 'jpg', 'signature_c1');

        // $this->ResourceManager->deleteResource(63, 2,'patients');

    
    }



    // /**
    //  * getSpecialist method
    //  *
    //  * @return \Cake\Network\Response|null
    //  */
    // public function getSpecialist()
    // {

    //     /**
    //      * Loading PermissionsRoles model
    //      */
    //     $this->loadModel('Users');
        
    //     $specialists = $this->Specialists->find('all', [
            
    //         'conditions' => ['Specialists.activated =' => '1']
    //     ]);

    //     $this->set(compact('specialists'));
    //     $this->set('_serialize', ['specialists']);
    // }

    /**
     * Obtiene todos los especialistas.
     * @return [type] [description]
     */
    public function getAllSpecialist(){

         $specialists = $this->Specialists->find('all', 
            ['contain' => ['People'] ])->toArray();
        
         if ($specialists) {
        
            $success = true;

            $this->set(compact('success','specialists'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }

    }
    /**
     * Obtiene toda la informacion de un specialista.
     * @return [type] [description]
     */
    public function getSpecialistById(){


        $id= $this->request->data['id'];
        
         $specialists = $this->Specialists->find('all', 
            ['contain' => ['People'],
             'conditions'=>['Specialists.id'=>$id]
            ])->first();
       
        
         if ($specialists) {

            $success = true;

            $this->set(compact('success','specialists'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }

    }

    public function getPagSpecialist(){


        $data = $this->request->data;

        $offset = $data['offset'];
        
        $specialists = $this->Specialists->find('all', 
        ['contain' => ['People','Users'],
         'limit' => 10, 'offset' => $offset
        ]);

        $total = $this->Specialists->find('all')->count();
       
         if ($specialists) {
        
            $success = true;

            $this->set(compact('success','specialists','total'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }

    }

    public function getByUser(){
     
        $id= $this->Auth->user('id');

           $specialists = $this->Specialists->find('all', 
            ['fields' => ['Specialists.id'],
             'conditions'=>['Specialists.users_id'=>$id]
            ])->first();
        
         if ($specialists) {
        
            $success = true;

            $this->set(compact('success','specialists'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
    }

    public function getSpecialistResult()
    {
        $specialists = $this->Specialists->find('all', ['contain'=>['People'], 'fields'=>['People.id','People.first_name', 'People.last_name','Specialists.id']])->toArray();

        $specialists = json_decode( json_encode( $specialists ), true );
        

        

        if($specialists)
        {
            $success = true;

            $this->set(compact('success','specialists'));

        }else{

            $success = false;

            $this->set(compact('success'));
        }
    }
  

    /**
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com> 
     * 2016-09-09 08:47:28
     * Obtener firma de especialista 
     */
    public function getSpecialistSignature(){

        $id = $this->request->data['id'];

        $picture = $this->ResourceManager->getResources($id, 'specialist', 'specialist_signature');

        if(!$picture){
            //$errors = $this->ResourceManager->errors();
            $success = false;

            $this->set(compact('success'));            

        }else{

            $picture = $picture[0];

            $success = true;

            $this->set(compact('success','picture'));            

        }

    }


    /**
     * View method
     *
     * @param string|null $id Specialist id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $specialist = $this->Specialists->get($id, [
            'contain' => ['People', 'Users', 'Schedule']
        ]);

        $this->set('specialist', $specialist);
        $this->set('_serialize', ['specialist']);
    }

     /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addSpecialist()
    {
        $specialist = $this->Specialists->newEntity();

        if ($this->request->is('post')) {

            $specialist = $this->Specialists->patchEntity($specialist, $this->request->data);

            if ($this->Specialists->save($specialist)) {

            $success = true;

            $this->set(compact('success','specialist'));
                            
            
            } else {    

                $success = false;

                $errors = $specialist->errors();

                $this->set(compact('success','errors'));
            }
        }
       
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $specialist = $this->Specialists->newEntity();
        if ($this->request->is('post')) {
            $specialist = $this->Specialists->patchEntity($specialist, $this->request->data);
            if ($this->Specialists->save($specialist)) {
                $this->Flash->success(__('The specialist has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The specialist could not be saved. Please, try again.'));
            }
        }
        $people = $this->Specialists->People->find('list', ['limit' => 200]);
        $users = $this->Specialists->Users->find('list', ['limit' => 200]);
        $schedule = $this->Specialists->Schedule->find('list', ['limit' => 200]);
        $this->set(compact('specialist', 'people', 'users', 'schedule'));
        $this->set('_serialize', ['specialist']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Specialist id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $specialist = $this->Specialists->get($id, [
            'contain' => ['Schedule']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $specialist = $this->Specialists->patchEntity($specialist, $this->request->data);
            if ($this->Specialists->save($specialist)) {
                $this->Flash->success(__('The specialist has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The specialist could not be saved. Please, try again.'));
            }
        }
        $people = $this->Specialists->People->find('list', ['limit' => 200]);
        $users = $this->Specialists->Users->find('list', ['limit' => 200]);
        $schedule = $this->Specialists->Schedule->find('list', ['limit' => 200]);
        $this->set(compact('specialist', 'people', 'users', 'schedule'));
        $this->set('_serialize', ['specialist']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Specialist id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $specialist = $this->Specialists->get($id);
        if ($this->Specialists->delete($specialist)) {
            $this->Flash->success(__('The specialist has been deleted.'));
        } else {
            $this->Flash->error(__('The specialist could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
