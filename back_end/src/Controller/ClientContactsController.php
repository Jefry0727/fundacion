<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ClientContacts Controller
 *
 * @property \App\Model\Table\ClientContactsTable $ClientContacts
 */
class ClientContactsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['getClientContact', 'clientsContactTypes', 'addContact']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ContactTypes', 'Clients']
        ];
        $clientContacts = $this->paginate($this->ClientContacts);

        $this->set(compact('clientContacts'));
        $this->set('_serialize', ['clientContacts']);
    }

    /**
     * View method
     *
     * @param string|null $id Client Contact id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientContact = $this->ClientContacts->get($id, [
            'contain' => ['ContactTypes', 'Clients']
        ]);

        $this->set('clientContact', $clientContact);
        $this->set('_serialize', ['clientContact']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addContact()
    {
        $clientContact = $this->ClientContacts->newEntity();
        
            $clientContact = $this->ClientContacts->patchEntity($clientContact, $this->request->data);

            if ($this->ClientContacts->save($clientContact)) {

                $success = true;

                $this->set(compact('success', 'clientContact'));
              
            } else {

                $success = false;

                $this->set(compact('success'));
               
            }
        
       
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Contact id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientContact = $this->ClientContacts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientContact = $this->ClientContacts->patchEntity($clientContact, $this->request->data);
            if ($this->ClientContacts->save($clientContact)) {
                $this->Flash->success(__('The client contact has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The client contact could not be saved. Please, try again.'));
            }
        }
        $contactTypes = $this->ClientContacts->ContactTypes->find('list', ['limit' => 200]);
        $clients = $this->ClientContacts->Clients->find('list', ['limit' => 200]);
        $this->set(compact('clientContact', 'contactTypes', 'clients'));
        $this->set('_serialize', ['clientContact']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Contact id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientContact = $this->ClientContacts->get($id);
        if ($this->ClientContacts->delete($clientContact)) {
            $this->Flash->success(__('The client contact has been deleted.'));
        } else {
            $this->Flash->error(__('The client contact could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * [getClientContact description]
     * @return [type] [description]
     */
    public function getClientContact()
    {
        $clientContact = $this->ClientContacts->find('all', ['contain'=> ['ContactTypes']])->toArray();


        if($clientContact)
        {
            $success = true;

            $this->set(compact('success', 'clientContact'));
        }else{

            $success = false;

            $this->set(compact('success'));
        }
    }

    public function clientsContactTypes()
    {
        $clientContactType = $this->ClientContacts->ContactTypes->find('all')->toArray();

        if($clientContactType)
        {
            $success = true;

            $this->set(compact('success', 'clientContactType'));
        }else{

            $success = false;

            $this->set(compact('success'));            
        }
    }


}
