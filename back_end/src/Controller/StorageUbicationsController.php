<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * StorageUbications Controller
 *
 * @property \App\Model\Table\StorageUbicationsTable $StorageUbications
 */
class StorageUbicationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Centers']
        ];
        $storageUbications = $this->paginate($this->StorageUbications);

        $this->set(compact('storageUbications'));
        $this->set('_serialize', ['storageUbications']);
    }

    /**
     * View method
     *
     * @param string|null $id Storage Ubication id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $storageUbication = $this->StorageUbications->get($id, [
            'contain' => ['Centers']
        ]);

        $this->set('storageUbication', $storageUbication);
        $this->set('_serialize', ['storageUbication']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $storageUbication = $this->StorageUbications->newEntity();
        if ($this->request->is('post')) {
            $storageUbication = $this->StorageUbications->patchEntity($storageUbication, $this->request->data);
            if ($this->StorageUbications->save($storageUbication)) {
                $this->Flash->success(__('The storage ubication has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The storage ubication could not be saved. Please, try again.'));
            }
        }
        $centers = $this->StorageUbications->Centers->find('list', ['limit' => 200]);
        $this->set(compact('storageUbication', 'centers'));
        $this->set('_serialize', ['storageUbication']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Storage Ubication id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $storageUbication = $this->StorageUbications->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $storageUbication = $this->StorageUbications->patchEntity($storageUbication, $this->request->data);
            if ($this->StorageUbications->save($storageUbication)) {
                $this->Flash->success(__('The storage ubication has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The storage ubication could not be saved. Please, try again.'));
            }
        }
        $centers = $this->StorageUbications->Centers->find('list', ['limit' => 200]);
        $this->set(compact('storageUbication', 'centers'));
        $this->set('_serialize', ['storageUbication']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Storage Ubication id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $storageUbication = $this->StorageUbications->get($id);
        if ($this->StorageUbications->delete($storageUbication)) {
            $this->Flash->success(__('The storage ubication has been deleted.'));
        } else {
            $this->Flash->error(__('The storage ubication could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    public function getAllStorage(){
        // obtiene todas las bodegas habilitadas.
           $storage = $this->StorageUbications->find('all',['conditions'=>['StorageUbications.state'=>1]])->toArray();

        if($storage)
        {
            $success = true;

            $this->set(compact('success', 'storage'));
        }else{

            $success = false;

            $this->set(compact('success'));
        }
    }



    //  Obtiene las bodegas segun la sede a la que pertenescan
    //  2016-10-19
    //  Carlos Felipe Aguirre
    public function getStoragesByCenter(){

        $center_id = $this->request->data['id'];

        $storages = $this->StorageUbications->find('all',['conditions'=>['StorageUbications.centers_id'=>$center_id]]);
        
        if(!$storages){
            
            $success = false;
            $errors  = $storages->errors();
            $this->set( compact( 'success', 'errors' ) );
        
        }
        else{
            $success = true;
            $bodegas = $storages->toArray();
            $this->set( compact( 'success', 'bodegas' ) );

        } 
    }
}
