<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CardiologyErgometry Controller
 *
 * @property \App\Model\Table\CardiologyErgometryTable $CardiologyErgometry
 */
class CardiologyErgometryController extends AppController
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
        $cardiologyErgometry = $this->paginate($this->CardiologyErgometry);

        $this->set(compact('cardiologyErgometry'));
        $this->set('_serialize', ['cardiologyErgometry']);
    }

    /**
     * View method
     *
     * @param string|null $id Cardiology Ergometry id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cardiologyErgometry = $this->CardiologyErgometry->get($id, [
            'contain' => ['ControlFormats']
        ]);

        $this->set('cardiologyErgometry', $cardiologyErgometry);
        $this->set('_serialize', ['cardiologyErgometry']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addCardiologyErgo()
    {
        $data = $this->request->data;

        $code ='CEG'.$this->CardiologyErgometry->find('all')->count();

        $data['format_consec'] = $code;

        $data['users_id'] = $this->Auth->user('id');

            // if(empty( $data['users_id'] )){

            //      $data['users_id']  = 1;

            // }

        $cardiologyErgo = $this->CardiologyErgometry->newEntity();
    
        $cardiologyErgo = $this->CardiologyErgometry->patchEntity($cardiologyErgo, $data);

        if ($this->CardiologyErgometry->save($cardiologyErgo)) {

          $success = true;

          $this->set(compact('success', 'cardiologyErgo'));

        } else {

           $success = false;

           $errors = $cardiologyErgo->errors();

           $this->set(compact('success','errors'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Cardiology Ergometry id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cardiologyErgometry = $this->CardiologyErgometry->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cardiologyErgometry = $this->CardiologyErgometry->patchEntity($cardiologyErgometry, $this->request->data);
            if ($this->CardiologyErgometry->save($cardiologyErgometry)) {
                $this->Flash->success(__('The cardiology ergometry has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cardiology ergometry could not be saved. Please, try again.'));
            }
        }
        $controlFormats = $this->CardiologyErgometry->ControlFormats->find('list', ['limit' => 200]);
        $this->set(compact('cardiologyErgometry', 'controlFormats'));
        $this->set('_serialize', ['cardiologyErgometry']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cardiology Ergometry id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cardiologyErgometry = $this->CardiologyErgometry->get($id);
        if ($this->CardiologyErgometry->delete($cardiologyErgometry)) {
            $this->Flash->success(__('The cardiology ergometry has been deleted.'));
        } else {
            $this->Flash->error(__('The cardiology ergometry could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
