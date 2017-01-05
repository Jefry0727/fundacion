<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ClientBusiness Controller
 *
 * @property \App\Model\Table\ClientBusinessTable $ClientBusiness
 */
class ClientBusinessController extends AppController
{

     public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['getClientsBusiness', 'getBusinesTerm', 'getALlClients', 'addClientBusiness', 'edit', 'getCustomerBusiness']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clients', 'BusinessTerms', 'add']
        ];
        $clientBusiness = $this->paginate($this->ClientBusiness);

        $this->set(compact('clientBusiness'));
        $this->set('_serialize', ['clientBusiness']);
    }

    /**
     * View method
     *
     * @param string|null $id Client Busines id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientBusines = $this->ClientBusiness->get($id, [
            'contain' => ['Clients', 'BusinessTerms']
        ]);

        $this->set('clientBusines', $clientBusines);
        $this->set('_serialize', ['clientBusines']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addClientBusiness()
    {
        $data = $this->request->data;

        $clientBusines = $this->ClientBusiness->newEntity();


            $data['date_end'] = $data['date_end']." 10:10:10";
    

            $clientBusines = $this->ClientBusiness->patchEntity($clientBusines, $data);

            $savedClientBusines = $this->ClientBusiness->save($clientBusines);

            if ($savedClientBusines) {
               
                $success = true;

                $this->set(compact('success', 'clientBusines'));  

            } else {

                $success = false;

                $errors = $clientBusines->errors();

                $this->set(compact('success','errors'));

               
            }

                 
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Busines id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {

        $data = $this->request->data;

        $id = $data['id'];


        $clientBusines = $this->ClientBusiness->get($id, ['contain' => []]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $data['date_end'] = $data['date_end']." 10:10:10";
    
            $clientBusines = $this->ClientBusiness->patchEntity($clientBusines, $data);

            if ($this->ClientBusiness->save($clientBusines)) {
               
               $success = true;

               $this->set(compact('success', 'clientBusines'));

            } else {
               
               $success = false;

               $errors = $clientBusines->errors();

               $this->set(compact('success', 'errors'));

            }
        }
        
    }

    /**
     * Delete method
     *
     * @param string|null $data Client Busines id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($data = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientBusines = $this->ClientBusiness->get($id);
        if ($this->ClientBusiness->delete($clientBusines)) {
            $this->Flash->success(__('The client busines has been deleted.'));
        } else {
            $this->Flash->error(__('The client busines could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    public function getALlClients()
    {
        $getAllClients =  $this->ClientBusiness->Clients->find('all')->toArray();

        if($getAllClients)
        {
            $success=true ;

            $this->set(compact('success','getAllClients'));

        }else{

            $success=false ;

            $this->set(compact('success'));
        } 
    }


   /**
    * [getClientsBusiness description]
    * @return [type] [description]
    */
   public function getClientsBusiness()
   {

    $id = $this->request->data['idClient'];

    $clientBusines = $this->ClientBusiness->find('all',['conditions'=>['ClientBusiness.clients_id' => $id]])->toArray();

    foreach ($clientBusines as $clientBusine) {
    
        $clientBusine->date_end = $clientBusine->date_end->i18nFormat('yyyy-MM-dd');

        $clientBusine->created = $clientBusine->created->i18nFormat('yyyy-MM-dd');

    }

        if($clientBusines)
        {
            $success = true;

            $this->set(compact('success', 'clientBusines'));

        }else{

            $success = false;

            $this->set(compact('success','clientBusines'));
        }


   }

   public function getCustomerBusiness()
   {
       //$data =  $this->reques->data;

        $customerBusiness = $this->ClientBusiness->find('all', ['contain'=>['Clients', 'BusinessTerms'], 'conditions'=>['ClientBusiness.clients_id'=> 1]])->toArray();

        if($customerBusiness)
        {
            $success = true;

            $this->set(compact('success', 'customerBusiness'));
        }else{

            $success = false;

            $errors = $customerBusiness->errors();

            $this->set(compact('success', 'errors'));
        }

   }

    /**
     * [getBusinesTerm description]
     * @return [type] [description]
     */
    public function getBusinesTerm()
    {
        $businesTerm = $this->ClientBusiness->BusinessTerms->find('all')->toArray();

        if($businesTerm)
        {
            $success = true;

            $this->set(compact('success', 'businesTerm'));
        }else{

            $success = false;

            $this->set(compact('success'));
        }
    }
}
