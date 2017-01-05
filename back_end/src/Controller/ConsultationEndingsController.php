<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ConsultationEndings Controller
 *
 * @property \App\Model\Table\ConsultationEndingsTable $ConsultationEndings
 */
class ConsultationEndingsController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['getConsultatiosEndings']);

    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $consultationEndings = $this->paginate($this->ConsultationEndings);

        $this->set(compact('consultationEndings'));
        $this->set('_serialize', ['consultationEndings']);
    }

    public function getConsultatiosEndings(){

        $consultationEndings = $this->ConsultationEndings->find('all')->toArray();

        if($consultationEndings){

            $success = true;

            $this->set(compact('success', 'consultationEndings'));
        }else{

            $success = false;

            $errors = $consultationEndings->errors();

            $this->set(compact('success'));
        }

    }

    /**
     * View method
     *
     * @param string|null $id Consultation Ending id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consultationEnding = $this->ConsultationEndings->get($id, [
            'contain' => []
        ]);

        $this->set('consultationEnding', $consultationEnding);
        $this->set('_serialize', ['consultationEnding']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $consultationEnding = $this->ConsultationEndings->newEntity();
        if ($this->request->is('post')) {
            $consultationEnding = $this->ConsultationEndings->patchEntity($consultationEnding, $this->request->data);
            if ($this->ConsultationEndings->save($consultationEnding)) {
                $this->Flash->success(__('The consultation ending has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The consultation ending could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('consultationEnding'));
        $this->set('_serialize', ['consultationEnding']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Consultation Ending id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consultationEnding = $this->ConsultationEndings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consultationEnding = $this->ConsultationEndings->patchEntity($consultationEnding, $this->request->data);
            if ($this->ConsultationEndings->save($consultationEnding)) {
                $this->Flash->success(__('The consultation ending has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The consultation ending could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('consultationEnding'));
        $this->set('_serialize', ['consultationEnding']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Consultation Ending id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consultationEnding = $this->ConsultationEndings->get($id);
        if ($this->ConsultationEndings->delete($consultationEnding)) {
            $this->Flash->success(__('The consultation ending has been deleted.'));
        } else {
            $this->Flash->error(__('The consultation ending could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
