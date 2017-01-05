<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Marks Controller
 *
 * @property \App\Model\Table\MarksTable $Marks
 */
class MarksController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $marks = $this->paginate($this->Marks);

        $this->set(compact('marks'));
        $this->set('_serialize', ['marks']);
    }

    /**
     * View method
     *
     * @param string|null $id Mark id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mark = $this->Marks->get($id, [
            'contain' => []
        ]);

        $this->set('mark', $mark);
        $this->set('_serialize', ['mark']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mark = $this->Marks->newEntity();
        if ($this->request->is('post')) {
            $mark = $this->Marks->patchEntity($mark, $this->request->data);
            if ($this->Marks->save($mark)) {
                $this->Flash->success(__('The mark has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The mark could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('mark'));
        $this->set('_serialize', ['mark']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Mark id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mark = $this->Marks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mark = $this->Marks->patchEntity($mark, $this->request->data);
            if ($this->Marks->save($mark)) {
                $this->Flash->success(__('The mark has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The mark could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('mark'));
        $this->set('_serialize', ['mark']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Mark id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mark = $this->Marks->get($id);
        if ($this->Marks->delete($mark)) {
            $this->Flash->success(__('The mark has been deleted.'));
        } else {
            $this->Flash->error(__('The mark could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    // Obtiene un listado de marcas.
    public function getAllMarks (){

           $mark = $this->Marks->find('all')->toArray();

        if($mark)
        {
            $success = true;

            $this->set(compact('success', 'mark'));
        }else{

            $success = false;

            $this->set(compact('success'));
        }
    }
}
