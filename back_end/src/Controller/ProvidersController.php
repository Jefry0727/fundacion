<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Providers Controller
 *
 * @property \App\Model\Table\ProvidersTable $Providers
 */
class ProvidersController extends AppController
{
     public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['allProviders', 'getAllProviders', 'add', 'edit']);

    }

    public function allProviders()
    {
        $data = $this->request->data;

        $offset = $data['offset'];

        $providers = $this->Providers->find('all', ['limit' => 10, 'offset' => $offset ]);

        $total = $this->Providers->find('all')->count();

        if($providers)
        {
            $success = true;

            $this->set(compact('success', 'providers', 'total'));
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
        $providers = $this->paginate($this->Providers);

        $this->set(compact('providers'));
        $this->set('_serialize', ['providers']);
    }

    /**
     * View method
     *
     * @param string|null $id Provider id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $provider = $this->Providers->get($id, [
            'contain' => []
        ]);

        $this->set('provider', $provider);
        $this->set('_serialize', ['provider']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $provider = $this->Providers->newEntity();

        $provider = $this->Providers->patchEntity($provider, $this->request->data);

            if ($this->Providers->save($provider)) {

                $success = true;

                $this->set(compact('success', 'provider'));

            } else {
              
              $success = false;

              $this->set(compact('success'));

            }
        
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Provider id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $id = $this->request->data['id'];

        $provider = $this->Providers->get($id,  ['contain' => []]);

        if($this->request->is(['patch', 'post', 'put']))
        {
            $provider = $this->Providers->patchEntity($provider, $this->request->data);

            if($this->Providers->save($provider))
            {
                $success = true;

                $this->set(compact('success', 'provider'));

            }else{

                $success = false;

                $this->set(compact('success'));
            }
        }   

    }

    /**
     * Delete method
     *
     * @param string|null $id Provider id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $provider = $this->Providers->get($id);
        if ($this->Providers->delete($provider)) {
            $this->Flash->success(__('The provider has been deleted.'));
        } else {
            $this->Flash->error(__('The provider could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    /**
     * Obtiene lista de todos los proveedores.
     * @return [type] [description]
     */
    public function getAllProviders(){
        
        $provider = $this->Providers->find('all')->toArray();

        if($provider)
        {
            $success = true;

            $this->set(compact('success', 'provider'));

        }else{

            $success = false;

            $this->set(compact('success'));
        }






    }
}
