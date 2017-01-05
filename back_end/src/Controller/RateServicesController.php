<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Datasource\ConnectionManager;

/**
 * RateServices Controller
 *
 * @property \App\Model\Table\RateServicesTable $RateServices
 */
class RateServicesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Rates', 'Services']
        ];
        $rateServices = $this->paginate($this->RateServices);

        $this->set(compact('rateServices'));
        $this->set('_serialize', ['rateServices']);
    }

    /**
     * View method
     *
     * @param string|null $id Rate Service id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rateService = $this->RateServices->get($id, [
            'contain' => ['Rates', 'Services']
        ]);

        $this->set('rateService', $rateService);
        $this->set('_serialize', ['rateService']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rateService = $this->RateServices->newEntity();
        if ($this->request->is('post')) {
            $rateService = $this->RateServices->patchEntity($rateService, $this->request->data);
            if ($this->RateServices->save($rateService)) {
                $this->Flash->success(__('The rate service has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rate service could not be saved. Please, try again.'));
            }
        }
        $rates = $this->RateServices->Rates->find('list', ['limit' => 200]);
        $services = $this->RateServices->Services->find('list', ['limit' => 200]);
        $this->set(compact('rateService', 'rates', 'services'));
        $this->set('_serialize', ['rateService']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rate Service id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rateService = $this->RateServices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rateService = $this->RateServices->patchEntity($rateService, $this->request->data);
            if ($this->RateServices->save($rateService)) {
                $this->Flash->success(__('The rate service has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rate service could not be saved. Please, try again.'));
            }
        }
        $rates = $this->RateServices->Rates->find('list', ['limit' => 200]);
        $services = $this->RateServices->Services->find('list', ['limit' => 200]);
        $this->set(compact('rateService', 'rates', 'services'));
        $this->set('_serialize', ['rateService']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rate Service id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rateService = $this->RateServices->get($id);
        if ($this->RateServices->delete($rateService)) {
            $this->Flash->success(__('The rate service has been deleted.'));
        } else {
            $this->Flash->error(__('The rate service could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }



    public function getAnesthesiaItem(){
        
        $rates_id = $this->request->data['rates_id'];
        $conection = ConnectionManager::get('default');
        $res = $conection->execute(
            "
            SELECT 
                rate_services.value as valor,
                rate_services.value as cost,
                services.cup as ref,
                services.name 
            FROM 
                rate_services INNER JOIN services
                ON 
                rate_services.servicises_id = services.id 
            WHERE
                    rate_services.servicises_id = 40 AND rate_services.rates_id = " . $rates_id . " LIMIT 1
            "
            )->fetchAll('assoc');
        
        $res = $res[0];
        $res['valor'] = ( float ) $res['valor'];
        $res['cost'] = ( float ) $res['cost'];
        $res['desc'] = $res['name'];
        $res['cant']=1;
        $res['type'] = false; // studio
        $res['service'] = null;
        $res['supplies'] = null;
        $res['anesthesia'] = true;

        $this->set(compact('res'));

    }
}
