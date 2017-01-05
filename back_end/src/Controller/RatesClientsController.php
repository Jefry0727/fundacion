<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RatesClients Controller
 *
 * @property \App\Model\Table\RatesClientsTable $RatesClients
 */
class RatesClientsController extends AppController
{


    public function initialize()
    {

        parent::initialize();
        $this->Auth->allow(['token','getByClient','getRateClient', 'ratesClients']);
    }



    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
        'contain' => ['Rates', 'Clients']
        ];
        $ratesClients = $this->paginate($this->RatesClients);

        $this->set(compact('ratesClients'));
        $this->set('_serialize', ['ratesClients']);
    }

    public function getByClient(){

       // $this->autoRender = false;
       // $idClient  = 8;

        $data = $this->request->data;

        $idClient  = $data['id'];        

        $rates = $this->RatesClients->find('all', 
            ['contain' => ['Clients','Rates'],
            'conditions'=>['Clients.id' => $idClient]
            ])->Select(['RatesClients.id','Rates.id','Rates.name'])->toArray();

        if ($rates) {

            $success = true;

            $this->set(compact('success','rates'));

        }else{

            $success = false;

            $this->set(compact('success'));

        }

    }

    public function ratesClients(){

        $data =  $this->request->data['id'];

         $ratesClient = $this->RatesClients->find('all', ['conditions'=>['RatesClients.clients_id'=> $data], 'contain'=>['Clients', 'Rates']]);


        if($ratesClient){

            $success = true;


            $ratesClient = $ratesClient->toArray();

            $this->set(compact('success','ratesClient'));
        }else{

            $success = false;

            $errors = $ratesClient->errors();

            $this->set(compact('success', 'errors'));
        }

    }

    /**
     * View method
     *
     * @param string|null $id Rates Client id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ratesClient = $this->RatesClients->get($id, [
            'contain' => ['Rates', 'Clients']
            ]);

        $this->set('ratesClient', $ratesClient);
        $this->set('_serialize', ['ratesClient']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ratesClient = $this->RatesClients->newEntity();
        if ($this->request->is('post')) {
            $ratesClient = $this->RatesClients->patchEntity($ratesClient, $this->request->data);
            if ($this->RatesClients->save($ratesClient)) {
                $this->Flash->success(__('The rates client has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rates client could not be saved. Please, try again.'));
            }
        }
        $rates = $this->RatesClients->Rates->find('list', ['limit' => 200]);
        $clients = $this->RatesClients->Clients->find('list', ['limit' => 200]);
        $this->set(compact('ratesClient', 'rates', 'clients'));
        $this->set('_serialize', ['ratesClient']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rates Client id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ratesClient = $this->RatesClients->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ratesClient = $this->RatesClients->patchEntity($ratesClient, $this->request->data);
            if ($this->RatesClients->save($ratesClient)) {
                $this->Flash->success(__('The rates client has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rates client could not be saved. Please, try again.'));
            }
        }
        $rates = $this->RatesClients->Rates->find('list', ['limit' => 200]);
        $clients = $this->RatesClients->Clients->find('list', ['limit' => 200]);
        $this->set(compact('ratesClient', 'rates', 'clients'));
        $this->set('_serialize', ['ratesClient']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rates Client id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ratesClient = $this->RatesClients->get($id);
        if ($this->RatesClients->delete($ratesClient)) {
            $this->Flash->success(__('The rates client has been deleted.'));
        } else {
            $this->Flash->error(__('The rates client could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
