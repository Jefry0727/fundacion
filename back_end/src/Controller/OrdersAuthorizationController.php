<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OrdersAuthorization Controller
 *
 * @property \App\Model\Table\OrdersAuthorizationTable $OrdersAuthorization
 */
class OrdersAuthorizationController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Orders', 'Users']
        ];
        $ordersAuthorization = $this->paginate($this->OrdersAuthorization);

        $this->set(compact('ordersAuthorization'));
        $this->set('_serialize', ['ordersAuthorization']);
    }

    /**
     * View method
     *
     * @param string|null $id Orders Authorization id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ordersAuthorization = $this->OrdersAuthorization->get($id, [
            'contain' => ['Orders', 'Users']
        ]);

        $this->set('ordersAuthorization', $ordersAuthorization);
        $this->set('_serialize', ['ordersAuthorization']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $this->request->data['created'] = date('Y-m-d');

        $ordersAuthorization = $this->OrdersAuthorization->newEntity();

        if ($this->request->is('post')) {
        
            $ordersAuthorization = $this->OrdersAuthorization->patchEntity($ordersAuthorization, $this->request->data);
        
            if ($this->OrdersAuthorization->save($ordersAuthorization)) {
               
                $success = true;
                $this->set( compact( 'success' ) );

            } else {
                $success = false;
                $this->set( compact( 'success' ) );
            }
        }
    
    }

    /**
     * Edit method
     *
     * @param string|null $id Orders Authorization id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {

         if( $id == null && empty( $this->request->data['authorization_id'] ) ){
        
            $id = $this->request->data['authorization_id'];
        
        }
        
        $ordersAuthorization = $this->OrdersAuthorization->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ordersAuthorization = $this->OrdersAuthorization->patchEntity($ordersAuthorization, $this->request->data);
            if ($this->OrdersAuthorization->save($ordersAuthorization)) {
                $success = true;
                $this->set( compact( 'success' ) );
            } else {
                $success = false;
                $this->set( compact( 'success' ) );
            }
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Orders Authorization id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ordersAuthorization = $this->OrdersAuthorization->get($id);
        if ($this->OrdersAuthorization->delete($ordersAuthorization)) {
            $this->Flash->success(__('The orders authorization has been deleted.'));
        } else {
            $this->Flash->error(__('The orders authorization could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }




    // Esta funcion checa si esta autorizada una orden si
    // es que lo requiere 
    // retorna true si esta autorizada o false en caso contrario
    public function isAuthorized(){
        $ordersId = $this->request->data['orders_id'];
        $resultado = $this->OrdersAuthorization->find()
                                               ->where([
                                                    'orders_id'=>$ordersId,
                                                    'state'=>1]
                                                    )
                                               ->limit(1)
                                               ->toArray();
        
        if( !empty( $resultado[0] ) ){
            
            $success = true;
            $result = true;
            $order = $resultado[0];
            $this->set( compact( 'success', 'result', 'order' ) );

        }
        else{

            $success = false;
            $result = false;
            $this->set( compact( 'success', 'result' ) );
        
        }

    }


}
