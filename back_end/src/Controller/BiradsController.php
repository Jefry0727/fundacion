<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Birads Controller
 *
 * @property \App\Model\Table\BiradsTable $Birads
 */
class BiradsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
        'contain' => ['Results']
        ];
        $birads = $this->paginate($this->Birads);

        $this->set(compact('birads'));
        $this->set('_serialize', ['birads']);
    }

    /**
     * View method
     *
     * @param string|null $id Birad id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $birad = $this->Birads->get($id, [
            'contain' => ['Results']
            ]);

        $this->set('birad', $birad);
        $this->set('_serialize', ['birad']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $birad = $this->Birads->newEntity();

        $birad = $this->Birads->patchEntity($birad, $this->request->data);
        if ($this->Birads->save($birad)) {

          $success = true;
          $this->set(compact('success','birad'));
      } else {
        $success = false;
        $errors = $birad->errors();
        $this->set(compact('success','errors'));
    }
}

    /**
     * Obtiene los birrads de una atencion
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-10-19
     * @datetime 2016-10-19T12:11:49-0500
     * @return   [type]                   [description]
     */
    // public function getByAttention(){

    //     $this->request->data();
    //     $birad = $this->Birads->find('',['conditions'=>])->first()
    //     ;

    // }

    /**
     * Edit method
     *
     * @param string|null $id Birad id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $birad = $this->Birads->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $birad = $this->Birads->patchEntity($birad, $this->request->data);
            if ($this->Birads->save($birad)) {
                $this->Flash->success(__('The birad has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The birad could not be saved. Please, try again.'));
            }
        }
        $results = $this->Birads->Results->find('list', ['limit' => 200]);
        $this->set(compact('birad', 'results'));
        $this->set('_serialize', ['birad']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Birad id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $birad = $this->Birads->get($id);
        if ($this->Birads->delete($birad)) {
            $this->Flash->success(__('The birad has been deleted.'));
        } else {
            $this->Flash->error(__('The birad could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
