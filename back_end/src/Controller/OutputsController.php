<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Outputs Controller
 *
 * @property \App\Model\Table\OutputsTable $Outputs
 */
class OutputsController extends AppController
{   

    public function initialize()
    {
        parent::initialize();
        // $this->Auth->allow(['addOutputs']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $outputs = $this->paginate($this->Outputs);

        $this->set(compact('outputs'));
        $this->set('_serialize', ['outputs']);
    }

    /**
     * View method
     *
     * @param string|null $id Output id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $output = $this->Outputs->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('output', $output);
        $this->set('_serialize', ['output']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $output = $this->Outputs->newEntity();
        if ($this->request->is('post')) {
            $output = $this->Outputs->patchEntity($output, $this->request->data);
            if ($this->Outputs->save($output)) {
                $this->Flash->success(__('The output has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The output could not be saved. Please, try again.'));
            }
        }
        $users = $this->Outputs->Users->find('list', ['limit' => 200]);
        $this->set(compact('output', 'users'));
        $this->set('_serialize', ['output']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Output id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $output = $this->Outputs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $output = $this->Outputs->patchEntity($output, $this->request->data);
            if ($this->Outputs->save($output)) {
                $this->Flash->success(__('The output has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The output could not be saved. Please, try again.'));
            }
        }
        $users = $this->Outputs->Users->find('list', ['limit' => 200]);
        $this->set(compact('output', 'users'));
        $this->set('_serialize', ['output']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Output id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $output = $this->Outputs->get($id);
        if ($this->Outputs->delete($output)) {
            $this->Flash->success(__('The output has been deleted.'));
        } else {
            $this->Flash->error(__('The output could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    //funcion para añadir salidas 
    public function addOutputs(){

        $this->loadModel('OutputsDetails');

        $data =  $this->request->data;

         $user = $this->Auth->user('id');

        for ($i=0; $i < count($data['items']); $i++) { 

            //se asignan los atributos a un nuevo array para agregarlos a la bd 
            $data_items = array (

                'request_code' => $data['items'][$i]['requestCode'],
                'observation'  => $data['items'][$i]['observation'],
                'outputs'      => $data['items'][$i]['salida'],
                'users_id'     => $this->Auth->user('id'),
                'state'        => 1
            );


            $output = $this->Outputs->newEntity();

            $output = $this->Outputs->patchEntity($output, $data_items);

                if ($this->Outputs->save($output)) {

                    // se retorna un id outputs para guardar ahora en outputsDetails
                    $data_items_details = array (

                        'output_code'       => $data['items'][$i]['requestCode'],
                        'quant_output'      => $data['items'][$i]['salida'],
                        'value'             => 1,
                        'outputs_id'        => $output['id'],
                        'state'             => 1,
                        'storage_inputs_id' => $data['items'][$i]['inputs_id']

                    );

                    // pr($data_items_details[$i]);

                    $outputsDetails = $this->OutputsDetails->newEntity();

                    $outputsDetails = $this->OutputsDetails->patchEntity($outputsDetails, $data_items_details);

                    if ($this->OutputsDetails->save($outputsDetails)) { 

                        $success = true;

                        $this->set(compact('success','OutputsDetails'));

                    }else{

                        $success = false;
                        
                        $errors = $OutputsDetails->errors();

                        $this->set(compact('success','errors'));
                
                    }
    
                }else{

                        $success = false;
                      
                        $errors = $output->errors();

                        $this->set(compact('success','errors'));
                }

        }   

    }
}
