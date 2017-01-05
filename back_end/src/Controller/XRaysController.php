<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * XRays Controller
 *
 * @property \App\Model\Table\XRaysTable $XRays
 */
class XRaysController extends AppController
{


   public function initialize()
    {
        parent::initialize();
        //$this->Auth->allow(['addXray']);
        $this->loadComponent('ResourceManager');
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
        $xRays = $this->paginate($this->XRays);

        $this->set(compact('xRays'));
        $this->set('_serialize', ['xRays']);
    }

    /**
     * View method
     *
     * @param string|null $id X Ray id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $xRay = $this->XRays->get($id, [
            'contain' => ['ControlFormats']
        ]);

        $this->set('xRay', $xRay);
        $this->set('_serialize', ['xRay']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addXray(){
         
        $data = $this->request->data;

        $code ='XRA'.$this->XRays->find('all')->count();

        $data['format_consec'] = $code;

        $data['users_id'] = $this->Auth->user('id');

        // if($data['users_id'] == null){

        //     $data['users_id'] = 1;

        // }
        // 

        $xray = $this->XRays->newEntity();

        $xray = $this->XRays->patchEntity($xray, $data);

        // pr($xray);
        // exit();

        if ($this->XRays->save($xray)) {

            $success = true;

            $this->set(compact('success', 'xray'));

        } else {

            $success = false;

            $errors = $xray->errors();

            $this->set(compact('success','errors'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id X Ray id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null){
        $xRay = $this->XRays->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $xRay = $this->XRays->patchEntity($xRay, $this->request->data);
            if ($this->XRays->save($xRay)) {
                $this->Flash->success(__('The x ray has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The x ray could not be saved. Please, try again.'));
            }
        }
        $controlFormats = $this->XRays->ControlFormats->find('list', ['limit' => 200]);
        $this->set(compact('xRay', 'controlFormats'));
        $this->set('_serialize', ['xRay']);
    }

    /**
     * Delete method
     *
     * @param string|null $id X Ray id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $xRay = $this->XRays->get($id);
        if ($this->XRays->delete($xRay)) {
            $this->Flash->success(__('The x ray has been deleted.'));
        } else {
            $this->Flash->error(__('The x ray could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
