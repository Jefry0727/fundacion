<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CardiologyEkg Controller
 *
 * @property \App\Model\Table\CardiologyEkgTable $CardiologyEkg
 */
class CardiologyEkgController extends AppController
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
        $cardiologyEkg = $this->paginate($this->CardiologyEkg);

        $this->set(compact('cardiologyEkg'));
        $this->set('_serialize', ['cardiologyEkg']);
    }

    /**
     * View method
     */
    public function view($id = null)
    {
        $cardiologyEkg = $this->CardiologyEkg->get($id, [
            'contain' => ['ControlFormats']
            ]);

        $this->set('cardiologyEkg', $cardiologyEkg);
        $this->set('_serialize', ['cardiologyEkg']);
    }

    /**
     * Add method

     */
    public function addCardiologyEkg()
    {
        $data = $this->request->data;

        $code ='CEK'.$this->CardiologyEkg->find('all')->count();

        $data['format_consec'] = $code;

        $data['users_id'] = $this->Auth->user('id');

        // if($data['users_id'] == null){

        //     $data['users_id'] = 1;

        // }

        $cardiology = $this->CardiologyEkg->newEntity();
        
        $cardiology = $this->CardiologyEkg->patchEntity($cardiology, $data);

        if ($this->CardiologyEkg->save($cardiology)) {

          $success = true;

          $this->set(compact('success', 'cardiology'));

      } else {

         $success = false;

         $errors = $this->$cardiology->errors();

         $this->set(compact('success','errors'));
     }
 }

    /**
     * Edit method
     *
     * @param string|null $id Cardiology Ekg id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cardiologyEkg = $this->CardiologyEkg->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cardiologyEkg = $this->CardiologyEkg->patchEntity($cardiologyEkg, $this->request->data);
            if ($this->CardiologyEkg->save($cardiologyEkg)) {
                $this->Flash->success(__('The cardiology ekg has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cardiology ekg could not be saved. Please, try again.'));
            }
        }
        $controlFormats = $this->CardiologyEkg->ControlFormats->find('list', ['limit' => 200]);
        $this->set(compact('cardiologyEkg', 'controlFormats'));
        $this->set('_serialize', ['cardiologyEkg']);
    }

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cardiologyEkg = $this->CardiologyEkg->get($id);
        if ($this->CardiologyEkg->delete($cardiologyEkg)) {
            $this->Flash->success(__('The cardiology ekg has been deleted.'));
        } else {
            $this->Flash->error(__('The cardiology ekg could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
