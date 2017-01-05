<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PruebaUsuario Controller
 *
 * @property \App\Model\Table\PruebaUsuarioTable $PruebaUsuario
 */
class PruebaUsuarioController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $pruebaUsuario = $this->paginate($this->PruebaUsuario);

        $this->set(compact('pruebaUsuario'));
        $this->set('_serialize', ['pruebaUsuario']);
    }

    /**
     * View method
     *
     * @param string|null $id Prueba Usuario id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pruebaUsuario = $this->PruebaUsuario->get($id, [
            'contain' => []
        ]);

        $this->set('pruebaUsuario', $pruebaUsuario);
        $this->set('_serialize', ['pruebaUsuario']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $data=   $this->request->data['entity'];     
        $pruebaUsuario = $this->PruebaUsuario->newEntity();
       
            $pruebaUsuario = $this->PruebaUsuario->patchEntity($pruebaUsuario, $data);

            if ($this->PruebaUsuario->save($pruebaUsuario)) {

                $success = true;
                $this->set(compact('success'));
               
               
            } else {

               $success = false;

               $errors=$pruebaUsuario->errors();

               $this->set(compact('success','errors'));
            }
     
      
      
    }

    /**
     * Edit method
     *
     * @param string|null $id Prueba Usuario id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pruebaUsuario = $this->PruebaUsuario->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pruebaUsuario = $this->PruebaUsuario->patchEntity($pruebaUsuario, $this->request->data);
            if ($this->PruebaUsuario->save($pruebaUsuario)) {
                $this->Flash->success(__('The prueba usuario has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The prueba usuario could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('pruebaUsuario'));
        $this->set('_serialize', ['pruebaUsuario']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Prueba Usuario id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pruebaUsuario = $this->PruebaUsuario->get($id);
        if ($this->PruebaUsuario->delete($pruebaUsuario)) {
            $this->Flash->success(__('The prueba usuario has been deleted.'));
        } else {
            $this->Flash->error(__('The prueba usuario could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
