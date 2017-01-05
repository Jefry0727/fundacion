<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * Clients Controller
 *
 * @property \App\Model\Table\ClientsTable $Clients
 */
class ClientsController extends AppController
{


    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add','edit','delete','index','get','getClientSelected', 'searchClientsContacts', 'getCodeUnic', 'getPlanForUser']);
    }

    public function getPlanForUser(){

        $connection = ConnectionManager::get('default');

        $this->request->data;

        $ratesClient = $connection->execute(" SELECT clients.id, clients.name,  clients.nit, 
            clients.ars_code, clients.state as stateClient,
            clients.municipalities_id, clients.ciiu,
            rates_clients.id, rates_clients.rates_id, rates_clients.clients_id,
            rates_clients.state as stateClientsRates,rates.id as idRates, rates.name, rates.state as stateRate
            FROM clients
            INNER JOIN(rates_clients, rates)
            ON clients.id = rates_clients.clients_id
            AND rates_clients.rates_id =  rates.id
            WHERE clients.id = 2")->fetchAll('assoc');

        if($ratesClient){

            $success = true;

            $this->set(compact('success', 'ratesClient'));

        }else{

            $success = false;

            $errors = $ratesClient->errors();

            $this->set(compact('success', 'errors'));

        }
    }

    public function searchClientsContacts()
    {

        $clientsContacts = $this->Clients->find('all', ['contain'=>['ClientContacts']])->toArray();

        if($clientsContacts)
        {
            $success = true;

            $this->set(compact('success', 'clientsContacts'));

        }else{

            $success = false;

            $errors = $clientsContacts->errors();

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
        //$this->paginate = [
        //    'contain' => ['Municipalities']
       // ];
        $clients = $this->paginate($this->Clients);

        $this->set(compact('clients'));
        $this->set('_serialize', ['clients']);
        pr($clients);
    }


    public function get(){

          $clients = $this->Clients->find('all', ['order' => ['Clients.name'=>'asc']] )->toArray();

        if ($clients) {
        
            $success = true;

            $this->set(compact('success','clients'));
    
        }else{
        
            $success = false;

            $errors = $clients->errors();

            $this->set(compact('success', 'errors'));

        }

    }

    public function getEnable(){

          $clients = $this->Clients->find('all' ,
            ['conditions'=>['Clients.state' => 1]]
          )->order(['Clients.name' => 'ASC'])->toArray();

        if ($clients) {
        
            $success = true;

            $this->set(compact('success','clients'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
    }


    public function getClientSelected(){

        $data = $this->request->data;

        $clients = $this->Clients->find('all' , ['conditions'=>['Clients.id' => $data['id']]])->toArray();

        if ($clients) {
        
            $success = true;

            $this->set(compact('success','clients'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
    }


    public function getByPagination(){


        $data = $this->request->data;
        
        $offset = $data['offset'];

        $clients = $this->Clients->find('all', ['limit' => 10,'offset'=> $offset,['contain'=>['ClientContacts']]]);

        $total = $this->Clients->find('all')->count();
        
        if ($clients) {
        
            $success = true;

            $this->set(compact('success','clients','total'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
    }

    /**
     * View method
     *
     * @param string|null $id Client id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $client = $this->Clients->get($id, [
            'contain' => ['Municipalities', 'Rates']
        ]);

        $this->set('client', $client);
        $this->set('_serialize', ['client']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $client = $this->Clients->newEntity();

        if( $this->request->data['types_client_id'] == 2 ){

            $this->request->data['state'] = 0;

        }


        $client = $this->Clients->patchEntity($client, $this->request->data);
      
          
      
        
        if ($this->Clients->save($client)) {
        
            // $this->Clients->addInitialContacs($client['id']);

            $success = true;

            $this->set(compact('success','client'));

        } else {

            $success = false;

            $errors = $client->errors();         
    
            $this->set(compact('success','errors'));
        
        }
        
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Client id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {

         $id = $this->request->data['id'];

        $client = $this->Clients->get($id, ['contain' => []]);


        if ($this->request->is(['patch', 'post', 'put']))  {

            $client = $this->Clients->patchEntity($client, $this->request->data);

            if ($this->Clients->save($client)) {
                                   
                $success = true;

                $this->set(compact('success','client'));
                            
            
            } else {    

                $success = false;

                $errors = $client->errors();

                $this->set(compact('success','errors'));
            }
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Client id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $client = $this->Clients->get($id);
        if ($this->Clients->delete($client)) {
            $this->Flash->success(__('The client has been deleted.'));
        } else {
            $this->Flash->error(__('The client could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    
}
