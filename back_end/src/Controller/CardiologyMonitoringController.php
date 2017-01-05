<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CardiologyMonitoring Controller
 *
 * @property \App\Model\Table\CardiologyMonitoringTable $CardiologyMonitoring
 */
class CardiologyMonitoringController extends AppController
{   

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['addCardiologyMonitoring']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ControlFormats']
        ];
        $cardiologyMonitoring = $this->paginate($this->CardiologyMonitoring);

        $this->set(compact('cardiologyMonitoring'));
        $this->set('_serialize', ['cardiologyMonitoring']);
    }

    /**
     * View method
     *
     * @param string|null $id Cardiology Monitoring id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cardiologyMonitoring = $this->CardiologyMonitoring->get($id, [
            'contain' => ['ControlFormats']
        ]);

        $this->set('cardiologyMonitoring', $cardiologyMonitoring);
        $this->set('_serialize', ['cardiologyMonitoring']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addCardiologyMonitoring()
    {
        $data = $this->request->data;

        $code ='CMO'.$this->CardiologyMonitoring->find('all')->count();

        $data['format_consec'] = $code;

        $data['users_id'] = $this->Auth->user('id');

            // if(empty( $data['users_id'] )){

            //      $data['users_id']  = 1;

            // }

        $cardiologyMoni = $this->CardiologyMonitoring->newEntity();
    
        $cardiologyMoni = $this->CardiologyMonitoring->patchEntity($cardiologyMoni, $data);

        if ($this->CardiologyMonitoring->save($cardiologyMoni)) {

          $success = true;

          $this->set(compact('success', 'cardiologyMoni'));

        } else {

           $success = false;

           $this->set(compact('success'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Cardiology Monitoring id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cardiologyMonitoring = $this->CardiologyMonitoring->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cardiologyMonitoring = $this->CardiologyMonitoring->patchEntity($cardiologyMonitoring, $this->request->data);
            if ($this->CardiologyMonitoring->save($cardiologyMonitoring)) {
                $this->Flash->success(__('The cardiology monitoring has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cardiology monitoring could not be saved. Please, try again.'));
            }
        }
        $controlFormats = $this->CardiologyMonitoring->ControlFormats->find('list', ['limit' => 200]);
        $this->set(compact('cardiologyMonitoring', 'controlFormats'));
        $this->set('_serialize', ['cardiologyMonitoring']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cardiology Monitoring id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cardiologyMonitoring = $this->CardiologyMonitoring->get($id);
        if ($this->CardiologyMonitoring->delete($cardiologyMonitoring)) {
            $this->Flash->success(__('The cardiology monitoring has been deleted.'));
        } else {
            $this->Flash->error(__('The cardiology monitoring could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
