<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Centers Controller
 *
 * @property \App\Model\Table\CentersTable $Centers
 */
class CentersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['get']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $centers = $this->paginate($this->Centers);

        $this->set(compact('centers'));
        $this->set('_serialize', ['centers']);
    }

    /**
     * View method
     *
     * @param string|null $id Center id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $center = $this->Centers->get($id, [
            'contain' => []
        ]);

        $this->set('center', $center);
        $this->set('_serialize', ['center']);
    }

     public function get(){

         $center = $this->Centers->find('all')->toArray();
         
         if ($center) {
        
            $success = true;

            $this->set(compact('success','center'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }


    }

    public function getSelectedCenters(){


        $data = $this->request->data;

        $center = $this->Centers->find('all' , ['conditions'=>['Centers.id' => $data['id']]])->first();
         
         if ($center) {
        
            $success = true;

            $this->set(compact('success','center'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }


    }


    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $center = $this->Centers->newEntity();
        if ($this->request->is('post')) {
            $center = $this->Centers->patchEntity($center, $this->request->data);
            if ($this->Centers->save($center)) {
                $this->Flash->success(__('The center has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The center could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('center'));
        $this->set('_serialize', ['center']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Center id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $center = $this->Centers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $center = $this->Centers->patchEntity($center, $this->request->data);
            if ($this->Centers->save($center)) {
                $this->Flash->success(__('The center has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The center could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('center'));
        $this->set('_serialize', ['center']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Center id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $center = $this->Centers->get($id);
        if ($this->Centers->delete($center)) {
            $this->Flash->success(__('The center has been deleted.'));
        } else {
            $this->Flash->error(__('The center could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
