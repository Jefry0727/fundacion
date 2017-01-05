<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Mammogram Controller
 *
 * @property \App\Model\Table\MammogramTable $Mammogram
 */
class MammogramController extends AppController
{

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
        $mammogram = $this->paginate($this->Mammogram);

        $this->set(compact('mammogram'));
        $this->set('_serialize', ['mammogram']);
    }

    /**
     * View method
     *
     * @param string|null $id Mammogram id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mammogram = $this->Mammogram->get($id, [
            'contain' => ['ControlFormats']
        ]);

        $this->set('mammogram', $mammogram);
        $this->set('_serialize', ['mammogram']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $data = $this->request->data;
          $code ='MAM'.$this->Mammogram->find('all')->count();

        $data['format_consec'] = $code;

        $data['users_id'] = $this->Auth->user('id');

        // if($data['users_id'] == null){

        //     $data['users_id'] = 1;

        // }


        $mammogram = $this->Mammogram->newEntity();

        $mammogram = $this->Mammogram->patchEntity($mammogram, $data);

        if ($this->Mammogram->save($mammogram)) {

            $success = true;

            $this->set(compact('success', 'mammogram'));

        } else {

            $success = false;

            $errors = $mammogram->errors();

            $this->set(compact('success','errors'));
        }
      
    }

    /**
     * Edit method
     *
     * @param string|null $id Mammogram id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mammogram = $this->Mammogram->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mammogram = $this->Mammogram->patchEntity($mammogram, $this->request->data);
            if ($this->Mammogram->save($mammogram)) {
                $this->Flash->success(__('The mammogram has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The mammogram could not be saved. Please, try again.'));
            }
        }
        $controlFormats = $this->Mammogram->ControlFormats->find('list', ['limit' => 200]);
        $this->set(compact('mammogram', 'controlFormats'));
        $this->set('_serialize', ['mammogram']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Mammogram id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mammogram = $this->Mammogram->get($id);
        if ($this->Mammogram->delete($mammogram)) {
            $this->Flash->success(__('The mammogram has been deleted.'));
        } else {
            $this->Flash->error(__('The mammogram could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
