<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CardiologyConsultarionEco Controller
 *
 * @property \App\Model\Table\CardiologyConsultarionEcoTable $CardiologyConsultarionEco
 */
class CardiologyConsultarionEcoController extends AppController
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
        $cardiologyConsultarionEco = $this->paginate($this->CardiologyConsultarionEco);

        $this->set(compact('cardiologyConsultarionEco'));
        $this->set('_serialize', ['cardiologyConsultarionEco']);
    }

    /**
     * View method
     *
     * @param string|null $id Cardiology Consultarion Eco id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cardiologyConsultarionEco = $this->CardiologyConsultarionEco->get($id, [
            'contain' => ['ControlFormats']
        ]);

        $this->set('cardiologyConsultarionEco', $cardiologyConsultarionEco);
        $this->set('_serialize', ['cardiologyConsultarionEco']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addCardologyConsul()
    {
        $data = $this->request->data;

        $code ='CCO'.$this->CardiologyConsultarionEco->find('all')->count();

        $data['format_consec'] = $code;

        $data['users_id'] = $this->Auth->user('id');

        // if($data['users_id'] == null){

        //     $data['users_id'] = 1;

        // }

        $cardologyConsul = $this->CardiologyConsultarionEco->newEntity();

        $cardologyConsul = $this->CardiologyConsultarionEco->patchEntity($cardologyConsul, $data);

        if ($this->CardiologyConsultarionEco->save($cardologyConsul)) {

            $success = true;

            $this->set(compact('success', 'cardologyConsul'));

        } else {

            $success = false;

            $errors = $cardologyConsul->errors();

            $this->set(compact('success','errors'));
        }

    }

    /**
     * Edit method
     *
     * @param string|null $id Cardiology Consultarion Eco id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cardiologyConsultarionEco = $this->CardiologyConsultarionEco->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cardiologyConsultarionEco = $this->CardiologyConsultarionEco->patchEntity($cardiologyConsultarionEco, $this->request->data);
            if ($this->CardiologyConsultarionEco->save($cardiologyConsultarionEco)) {
                $this->Flash->success(__('The cardiology consultarion eco has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cardiology consultarion eco could not be saved. Please, try again.'));
            }
        }
        $controlFormats = $this->CardiologyConsultarionEco->ControlFormats->find('list', ['limit' => 200]);
        $this->set(compact('cardiologyConsultarionEco', 'controlFormats'));
        $this->set('_serialize', ['cardiologyConsultarionEco']);
    }

    /*
     * Delete method
     *
     * @param string|null $id Cardiology Consultarion Eco id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cardiologyConsultarionEco = $this->CardiologyConsultarionEco->get($id);
        if ($this->CardiologyConsultarionEco->delete($cardiologyConsultarionEco)) {
            $this->Flash->success(__('The cardiology consultarion eco has been deleted.'));
        } else {
            $this->Flash->error(__('The cardiology consultarion eco could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
