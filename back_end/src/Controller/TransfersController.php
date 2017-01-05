<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Transfers Controller
 *
 * @property \App\Model\Table\TransfersTable $Transfers
 */
class TransfersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Requests', 'StorageUbications']
        ];
        $transfers = $this->paginate($this->Transfers);

        $this->set(compact('transfers'));
        $this->set('_serialize', ['transfers']);
    }

    /**
     * View method
     *
     * @param string|null $id Transfer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transfer = $this->Transfers->get($id, [
            'contain' => ['Requests', 'StorageUbications']
        ]);

        $this->set('transfer', $transfer);
        $this->set('_serialize', ['transfer']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transfer = $this->Transfers->newEntity();
        if ($this->request->is('post')) {
            $transfer = $this->Transfers->patchEntity($transfer, $this->request->data);
            if ($this->Transfers->save($transfer)) {
                $this->Flash->success(__('The transfer has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The transfer could not be saved. Please, try again.'));
            }
        }
        $requests = $this->Transfers->Requests->find('list', ['limit' => 200]);
        $storageUbications = $this->Transfers->StorageUbications->find('list', ['limit' => 200]);
        $this->set(compact('transfer', 'requests', 'storageUbications'));
        $this->set('_serialize', ['transfer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Transfer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transfer = $this->Transfers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transfer = $this->Transfers->patchEntity($transfer, $this->request->data);
            if ($this->Transfers->save($transfer)) {
                $this->Flash->success(__('The transfer has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The transfer could not be saved. Please, try again.'));
            }
        }
        $requests = $this->Transfers->Requests->find('list', ['limit' => 200]);
        $storageUbications = $this->Transfers->StorageUbications->find('list', ['limit' => 200]);
        $this->set(compact('transfer', 'requests', 'storageUbications'));
        $this->set('_serialize', ['transfer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Transfer id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transfer = $this->Transfers->get($id);
        if ($this->Transfers->delete($transfer)) {
            $this->Flash->success(__('The transfer has been deleted.'));
        } else {
            $this->Flash->error(__('The transfer could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    //funcion para añadir salidas 
    public function addTransfer(){

        $this->loadModel('TransferDetails');

        $data =  $this->request->data;
        
        for ($i=0; $i < count($data['items']); $i++) { 

            //se asignan los atributos a un nuevo array para agregarlos a la bd 
            $data_items[$i] = array (

                'transfer_code'           => $data['items'][$i]['requestCode'],
                'observations'            => $data['items'][$i]['observation'],
                'state'                   => 1,
                'requests_id'             => 1,    
            );

            $transfers = $this->Transfers->newEntity();

            $transfers = $this->Transfers->patchEntity($transfers, $data_items[$i]);

                if ($this->Transfers->save($transfers)) {

                    // se retorna un id outputs para guardar ahora en outputsDetails
                    $data_items_details[$i] = array (


                        'state'             => 1,
                        'output_code'       => $transfers['transfer_code'],
                        'quant_output'      => $data['items'][$i]['salida'],
                        'transfers_id'      => $transfers['id'],
                        'value'             => 1,
                        'storage_inputs_id' => $data['items'][$i]['inputs_id'],
                        'product_details_id'=> $data['items'][$i]['product_details'],
                        'storage_ubications_id'   => $data['items'][$i]['storage_ubication']
                        
                    );

                    $transferDetails = $this->TransferDetails->newEntity();

                    $transferDetails = $this->TransferDetails->patchEntity($transferDetails, $data_items_details[$i]);

                    if ($this->TransferDetails->save($transferDetails)) { 

                        $success = true;

                        $this->set(compact('success','OutputsDetails'));

                    }else{

                        $success = false;

                        $this->set(compact('success'));
                    }
    
                }else{

                        $success = false;

                        $this->set(compact('success'));
                }

        }   

    }
}
