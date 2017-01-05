<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Inputs Controller
 *
 * @property \App\Model\Table\InputsTable $Inputs
 */
class InputsController extends AppController
{   

    // public function initialize()
    // {
    //     parent::initialize();
    //     $this->Auth->allow(['updateInputQuote']);
    // }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products', 'Providers', 'StorageUbications', 'Marks', 'Users', 'InvimaCodes', 'Units']
        ];
        $inputs = $this->paginate($this->Inputs);

        $this->set(compact('inputs'));
        $this->set('_serialize', ['inputs']);
    }

    /**
     * View method
     *
     * @param string|null $id Input id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $input = $this->Inputs->get($id, [
            'contain' => ['Products', 'Providers', 'StorageUbications', 'Marks', 'Users', 'InvimaCodes', 'Units']
        ]);

        $this->set('input', $input);
        $this->set('_serialize', ['input']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addInputs()
    {
          $data = $this->request->data;
          $data['users_id'] = $this->Auth->user('id');

         $input = $this->Inputs->newEntity();

            $input = $this->Inputs->patchEntity($input, $data);

            if ($this->Inputs->save($input)) {
                 $success = true;

                $this->set(compact('success','input'));
                
            } else {

                    $success = false;

                 $error = $input->errors();

                $this->set(compact('success','error'));

                
            }
    }

    /**
     * Edit method
     *
     * @param string|null $id Input id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $input = $this->Inputs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $input = $this->Inputs->patchEntity($input, $this->request->data);
            if ($this->Inputs->save($input)) {
                $this->Flash->success(__('The input has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The input could not be saved. Please, try again.'));
            }
        }
        $products = $this->Inputs->Products->find('list', ['limit' => 200]);
        $providers = $this->Inputs->Providers->find('list', ['limit' => 200]);
        $storageUbications = $this->Inputs->StorageUbications->find('list', ['limit' => 200]);
        $marks = $this->Inputs->Marks->find('list', ['limit' => 200]);
        $users = $this->Inputs->Users->find('list', ['limit' => 200]);
        $invimaCodes = $this->Inputs->InvimaCodes->find('list', ['limit' => 200]);
        $units = $this->Inputs->Units->find('list', ['limit' => 200]);
        $this->set(compact('input', 'products', 'providers', 'storageUbications', 'marks', 'users', 'invimaCodes', 'units'));
        $this->set('_serialize', ['input']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Input id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $input = $this->Inputs->get($id);
        if ($this->Inputs->delete($input)) {
            $this->Flash->success(__('The input has been deleted.'));
        } else {
            $this->Flash->error(__('The input could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function getInputProduct(){

        $data = $this->request->data;

        $idProducts = $data['idProduct'];

        $idStorage = $data['idStorage'];

        $inputs =  $this->Inputs->find('all',[

            'contain' => ['Products', 'Providers', 'StorageUbications', 'Marks', 'Users', 'InvimaCodes', 'Units'],

            'conditions'=> [

              "Inputs.products_id = '".$idProducts."'",

              "Inputs.storage_ubications_id = '".$idStorage."'",

            ]

        ])->first(); 


      $success = true;


      $this->set(compact('success','inputs'));

    }

    // public function getAllInputs(){

    //     $inputs = $this->Inputs->find('all',['contain'=>['Products','StorageUbications','Marks','InvimaCodes','Units','Providers']])->toArray();

    //     if($inputs){
    //          $success = true;

    //          $this->set(compact('success','inputs'));

    //     }else{
    //         $success = false;

    //         $this->set(compact('success'));
    //     }

    // }

    // public function updateInputQuote(){

    //     $data = $this->request->data;

    //     $inputs = $this->Inputs->get($data['idInput'], [
    //         'contain' => []
    //     ]);

    //         $inputs = $this->Inputs->patchEntity($inputs, $this->request->data);

    //         // $data['order_details_id']= 12;
    //         // $data['users_id'] = 1;
    //         // $data['order_states_id'] = 1;

    //         if ($this->Inputs->save($inputs)) {

    //             $success = true;

    //             $this->set(compact('success', 'inputs'));

    //         } else {
    //             $success = false;

    //             $this->set(compact('success'));
    //         }

    
    // }

    
}
