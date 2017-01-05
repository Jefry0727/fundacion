<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * StudiesSpecialists Controller
 *
 * @property \App\Model\Table\StudiesSpecialistsTable $StudiesSpecialists
 */
class StudiesSpecialistsController extends AppController
{
    public function initialize()
        {
            parent::initialize();
            $this->Auth->allow(['getAllBySpecialist', 'addAll', 'validateStudy', 'getFilterStudies', 'getFilter']);
        }

        public function getFilter()
        {
            $data = $this->request->data;

            $idSpecialist = $data['id'];

            $studiesSpecialists = $this->StudiesSpecialists->find('all', ['contain'=>['Studies'], 
                'conditions'=>['StudiesSpecialists.specialists_id' => $idSpecialist]
                ]);

            if($studiesSpecialists)
            {
                $success = true;

                $this->set(compact('success','studiesSpecialists'));
            }else{

                $success = false;

                $this->set(compact('success'));
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
            'contain' => ['Studies', 'Specialists']
        ];
        $studiesSpecialists = $this->paginate($this->StudiesSpecialists);

        $this->set(compact('studiesSpecialists'));
        $this->set('_serialize', ['studiesSpecialists']);
    }
    

    public function getAllBySpecialist(){

        $data = $this->request->data;

        $idSpecialist  = $data['id'];      

        //pr($data);

        $studyBySpecialist = $this->StudiesSpecialists->find('all', ['contain' => ['Studies'], 'conditions'=>['StudiesSpecialists.specialists_id' => $idSpecialist]])->toArray();


        
         if ($studyBySpecialist) {
        
            $success = true;

            $this->set(compact('success','studyBySpecialist'));
       
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
        
    }
    
     
    /**
     * View method
     *
     * @param string|null $id Studies Specialist id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $studiesSpecialist = $this->StudiesSpecialists->get($id, [
            'contain' => ['Studies', 'Specialists']
        ]);

        $this->set('studiesSpecialist', $studiesSpecialist);
        $this->set('_serialize', ['studiesSpecialist']);
    }

   
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $studiesSpecialist = $this->StudiesSpecialists->newEntity();
        if ($this->request->is('post')) {
            $studiesSpecialist = $this->StudiesSpecialists->patchEntity($studiesSpecialist, $this->request->data);
            if ($this->StudiesSpecialists->save($studiesSpecialist)) {
                $this->Flash->success(__('The studies specialist has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The studies specialist could not be saved. Please, try again.'));
            }
        }
        $studies = $this->StudiesSpecialists->Studies->find('list', ['limit' => 200]);
        $specialists = $this->StudiesSpecialists->Specialists->find('list', ['limit' => 200]);
        $this->set(compact('studiesSpecialist', 'studies', 'specialists'));
        $this->set('_serialize', ['studiesSpecialist']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Studies Specialist id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $studiesSpecialist = $this->StudiesSpecialists->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $studiesSpecialist = $this->StudiesSpecialists->patchEntity($studiesSpecialist, $this->request->data);
            if ($this->StudiesSpecialists->save($studiesSpecialist)) {

               $success = true;

               $this->set(compact('success', 'studiesSpecialist'));

            } else {

                $success = false;

                $this->set(compact('success'));
               
            }
        }
        
    }

    /**
     * Delete method
     *
     * @param string|null $id Studies Specialist id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {

        $studies = $this->request->data;

            foreach($studies as $study){
              $studiesSpecialist = $this->StudiesSpecialists->get($study['id']);

             if ($this->StudiesSpecialists->delete($studiesSpecialist)) {
      
                    $success = true;
              } else {
                $success = false;
                }
            }

        $this->set(compact('success'));

    }


    public function addAll(){
      

        if ($this->request->is('post')) {

            $studieSpecialists = $this->request->data;

            $success = true;
            
                foreach($studieSpecialists as $study){
            
                $exists  = $this->validateStudy($study['specialists_id'], $study['studies_id']);
                    
                    if(!$exists){
                    
                        $studieSpecialist = $this->StudiesSpecialists->newEntity();
                 
                        $studieSpecialist = $this->StudiesSpecialists->patchEntity($studieSpecialist, $study);
                     
                       if(!$this->StudiesSpecialists->save($studieSpecialist)){

                            $success = false;
                            break;
                        } 
                    }
               
                }


               $this->set(compact('success'));
                    

             }
    }

        public function validateStudy($idSpecialist,$idStudy){
               
            $studyBySpecialist = $this->StudiesSpecialists->
            find('all',  
                ['contain' => ['Studies'], 
                'conditions'=> [
                'StudiesSpecialists.specialists_id' => $idSpecialist,
                'StudiesSpecialists.studies_id' => $idStudy
                ]
                ])->toArray();


            return $studyBySpecialist;
        } 

    public function getFilterStudies(){

        $data = $this->request->data;

        $idSpecialist  = $data['idSpecialist'];
        $idSpecialization = $data['idSpecialization'];


        $studyBySpecialist = $this->StudiesSpecialists->
                        find('all',  
                            ['contain' => ['Studies'], 
                             'conditions'=> [
                                'StudiesSpecialists.specialists_id' => $idSpecialist,
                                'Studies.specializations_id' => $idSpecialization
                                ]
                             ])->toArray();
        
         if ($studyBySpecialist) {
        
            $success = true;

            $this->set(compact('success','studyBySpecialist'));
       
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
        
    }
    

    


}
