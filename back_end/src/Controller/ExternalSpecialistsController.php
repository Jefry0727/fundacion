<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ExternalSpecialists Controller
 *
 * @property \App\Model\Table\ExternalSpecialistsTable $ExternalSpecialists
 */
class ExternalSpecialistsController extends AppController
{   

     public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add','edit','index','delete','searchExternalSpecialist','querySpecialist']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $externalSpecialists = $this->paginate($this->ExternalSpecialists);

        $this->set(compact('externalSpecialists'));
        $this->set('_serialize', ['externalSpecialists']);
    }

    /**
     * View method
     *
     * @param string|null $id External Specialist id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if($id== null && !empty($this->request->data['id'])){
            $id = $this->request->data['id'];
        }
        $externalSpecialist = $this->ExternalSpecialists->get($id, [
            'contain' => []
        ]);

        $this->set('externalSpecialist', $externalSpecialist);
        $this->set('_serialize', ['externalSpecialist']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $specialist = $this->ExternalSpecialists->newEntity();

        $name = $this->request->data['name'];


        if ($this->request->is('post')) {

          
            $exsists = $this->ExternalSpecialists->find('all', ['conditions'=> ['ExternalSpecialists.name LIKE'=> '%'.$name.'%']])->count();
            if($exsists == 0){

                $specialist = $this->ExternalSpecialists->patchEntity($specialist, $this->request->data);

                if ($this->ExternalSpecialists->save($specialist)) {

                 $success = true;

                 $this->set(compact('success','specialist'));


             } else {    

                $success = false;

                $errors = $specialist->errors();

                $this->set(compact('success','errors'));
            }
        }else{

           $specialist = $this->ExternalSpecialists->find('all',['conditions'=>['ExternalSpecialists.name LIKE' => '%'.$name.'%']])->first();

           if ($specialist) {

            $success = true;

            $this->set(compact('success','specialist'));

        }else{

            $success = false;

            $errors = $specialist->errors();

            $this->set(compact('success','errors'));

        }



    }
}
}

    /**
     * Edit method
     *
     * @param string|null $id External Specialist id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $externalSpecialist = $this->ExternalSpecialists->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $externalSpecialist = $this->ExternalSpecialists->patchEntity($externalSpecialist, $this->request->data);
            if ($this->ExternalSpecialists->save($externalSpecialist)) {
                $this->Flash->success(__('The external specialist has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The external specialist could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('externalSpecialist'));
        $this->set('_serialize', ['externalSpecialist']);
    }

    /**
     * Delete method
     *
     * @param string|null $id External Specialist id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $externalSpecialist = $this->ExternalSpecialists->get($id);
        if ($this->ExternalSpecialists->delete($externalSpecialist)) {
            $this->Flash->success(__('The external specialist has been deleted.'));
        } else {
            $this->Flash->error(__('The external specialist could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

     public function searchExternalSpecialist()
    {

        $name = $this->request->data['names'];

        $results = $this->ExternalSpecialists->find('all',['conditions'=>['ExternalSpecialists.name LIKE' => '%'.$name.'%']]);

        foreach ($results as $result) {
            
        }
        /**
         * Sending the result
         */
        $this->set(compact('result'));

        // }else{

        //     $success = false;

        //     $errors = $results->errors();

        //     $this->set(compact('success','errors'));
        // }
    }

     /**
     * Función que se encarga de buscar los servicios por codigo cup o por nombre
     * @return [type] [description]
     */
    public function querySpecialist($term){

        $this->autoRender = false;

        /**
         * Si es tipo 1 buscar por nombre
         * @var Int
         */
        if(!is_numeric($term)){

            $services = $this->ExternalSpecialists->find('all',['conditions'=>["ExternalSpecialists.name like '%".$term."%' "]]);
           

        /**
         * De lo contrario buscar por codigo cup
         */
        }else{

            $services = false;

        }
        
        
            echo json_encode(Array('servicesExtSpe'=>$services));


        // $this->set(compact('services'));


    }



    public function getExternalSpecialist(){

        $data = $this->request->data;

        $offset = $data['offset'];

        $external = $this->ExternalSpecialists->find('all',

        [
         'limit' => 10, 'offset' => $offset 
        
        ]);

        $total = $this->ExternalSpecialists->find('all')->count();

            if ($external) {

               $success = true;

               $this->set(compact('success','external','total'));
                            
            
            } else {    

                $success = false;

                $errors = $external->errors();

                $this->set(compact('success','errors'));
            }
        }
}
